<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Batch;
use App\Models\Document;
use App\Models\Numerator;
use App\Models\MovimientoInventario;
use App\Http\Resources\InventoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'startdate' => 'sometimes|date',
            'enddate' => 'sometimes|date',
            'warehouse_id' => 'sometimes|integer',
        ]);

        $user = auth()->user();
        $query = Inventory::with(['user', 'warehouse', 'headquarter'])
            ->where('company_id', $user->company_id);

        if ($request->has('startdate')) {
            $query->whereDate('date', '>=', $request->startdate);
        }
        if ($request->has('enddate')) {
            $query->whereDate('date', '<=', $request->enddate);
        }
        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        // Limit results to sucursal unless sadmin/pfadmin
        if (!in_array($user->role->slug, ['sadmin', 'pfadmin'])) {
            $query->where('headquarter_id', $user->headquarter_id);
        }

        $data = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'data' => InventoryResource::collection($data),
            'message' => 'Listado de inventarios físicos',
            'error' => 0
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.physical_stock' => 'nullable|numeric|min:0',
            'items.*.observation' => 'nullable|string',
            'complete' => 'sometimes|boolean',
        ]);

        // Get Document for INV
        $hqId = $user->headquarter_id ?? 1;
        $document = Document::firstOrCreate(
            ['code' => 'INV'],
            [
                'name' => 'Inventario Físico',
                'headquarter_id' => $hqId,
                'status' => 1
            ]
        );

        // Find or create Numerator for this headquarter
        $numerator = Numerator::firstOrCreate(
            [
                'headquarter_id' => $hqId,
                'document_id' => $document->id,
            ],
            [
                'serial' => 'INV' . substr($hqId, 0, 1),
                'number' => 1,
                'status' => 1
            ]
        );

        $numberFormatted = $numerator->serial . '-' . str_pad($numerator->number, 6, '0', STR_PAD_LEFT);
        $status = $request->input('complete') ? 2 : 1; // 1 = Draft, 2 = Completed

        $inventory = DB::transaction(function () use ($request, $user, $numerator, $numberFormatted, $status) {
            $inventory = Inventory::create([
                'company_id' => $user->company_id,
                'headquarter_id' => $user->headquarter_id,
                'warehouse_id' => $request->warehouse_id,
                'user_id' => $user->id,
                'numerator_id' => $numerator->id,
                'number' => $numberFormatted,
                'date' => $request->date,
                'notes' => $request->notes,
                'status' => $status,
            ]);

            foreach ($request->items as $itemData) {
                // Only store items that have physical_stock provided/entered
                if (!isset($itemData['physical_stock']) || $itemData['physical_stock'] === '' || $itemData['physical_stock'] === null) {
                    continue;
                }

                $product = Product::findOrFail($itemData['product_id']);
                $systemStock = $product->getStockActual($request->warehouse_id);
                $physicalStock = (float) $itemData['physical_stock'];
                $difference = $physicalStock - $systemStock;

                $item = InventoryItem::create([
                    'inventory_id' => $inventory->id,
                    'product_id' => $product->id,
                    'system_stock' => $systemStock,
                    'physical_stock' => $physicalStock,
                    'difference' => $difference,
                    'observation' => $itemData['observation'] ?? null,
                ]);

                if ($status === 2) {
                    $this->consolidateProductStock($user, $request->warehouse_id, $product, $physicalStock, $difference, 'Ajuste por Inventario Físico #' . $numberFormatted);
                }
            }

            if ($status === 2) {
                // Increment numerator only when completed
                $numerator->increment('number');
            }

            return $inventory;
        });

        return response()->json([
            'data' => new InventoryResource(Inventory::with(['items.product', 'user', 'warehouse', 'headquarter'])->find($inventory->id)),
            'message' => $status === 2 ? 'Inventario guardado y completado correctamente' : 'Inventario guardado como borrador',
            'error' => 0
        ]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $inventory = Inventory::with(['items.product', 'user', 'warehouse', 'headquarter'])
            ->where('company_id', $user->company_id)
            ->findOrFail($id);

        return response()->json([
            'data' => new InventoryResource($inventory),
            'message' => 'Detalle del inventario físico',
            'error' => 0
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $inventory = Inventory::where('company_id', $user->company_id)->findOrFail($id);

        if ($inventory->status === 2) {
            return response()->json([
                'message' => 'No se puede modificar un inventario completado',
                'error' => 1
            ], 422);
        }

        $request->validate([
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.physical_stock' => 'nullable|numeric|min:0',
            'items.*.observation' => 'nullable|string',
            'complete' => 'sometimes|boolean',
        ]);

        $status = $request->input('complete') ? 2 : 1;

        DB::transaction(function () use ($request, $user, $inventory, $status) {
            $inventory->update([
                'notes' => $request->notes ?? $inventory->notes,
                'status' => $status,
            ]);

            // Re-sync items: delete old ones, recreate
            $inventory->items()->delete();

            foreach ($request->items as $itemData) {
                if (!isset($itemData['physical_stock']) || $itemData['physical_stock'] === '' || $itemData['physical_stock'] === null) {
                    continue;
                }

                $product = Product::findOrFail($itemData['product_id']);
                $systemStock = $product->getStockActual($inventory->warehouse_id);
                $physicalStock = (float) $itemData['physical_stock'];
                $difference = $physicalStock - $systemStock;

                InventoryItem::create([
                    'inventory_id' => $inventory->id,
                    'product_id' => $product->id,
                    'system_stock' => $systemStock,
                    'physical_stock' => $physicalStock,
                    'difference' => $difference,
                    'observation' => $itemData['observation'] ?? null,
                ]);

                if ($status === 2) {
                    $this->consolidateProductStock($user, $inventory->warehouse_id, $product, $physicalStock, $difference, 'Ajuste por Inventario Físico #' . $inventory->number);
                }
            }

            if ($status === 2) {
                $numerator = Numerator::find($inventory->numerator_id);
                if ($numerator) {
                    $numerator->increment('number');
                }
            }
        });

        return response()->json([
            'data' => new InventoryResource(Inventory::with(['items.product', 'user', 'warehouse', 'headquarter'])->find($inventory->id)),
            'message' => $status === 2 ? 'Inventario guardado y completado correctamente' : 'Inventario actualizado correctamente',
            'error' => 0
        ]);
    }

    public function complete($id)
    {
        $user = auth()->user();
        $inventory = Inventory::where('company_id', $user->company_id)->findOrFail($id);

        if ($inventory->status === 2) {
            return response()->json([
                'message' => 'Este inventario ya está completado',
                'error' => 1
            ], 422);
        }

        DB::transaction(function () use ($user, $inventory) {
            $inventory->update(['status' => 2]);

            foreach ($inventory->items as $item) {
                if ($item->physical_stock === null) {
                    continue;
                }

                $product = Product::findOrFail($item->product_id);

                // Recalculate difference in case stock has changed
                $systemStock = $product->getStockActual($inventory->warehouse_id);
                $physicalStock = (float) $item->physical_stock;
                $difference = $physicalStock - $systemStock;

                $item->update([
                    'system_stock' => $systemStock,
                    'difference' => $difference
                ]);

                $this->consolidateProductStock($user, $inventory->warehouse_id, $product, $physicalStock, $difference, 'Ajuste por Inventario Físico #' . $inventory->number);
            }

            $numerator = Numerator::find($inventory->numerator_id);
            if ($numerator) {
                $numerator->increment('number');
            }
        });

        return response()->json([
            'data' => new InventoryResource(Inventory::with(['items.product', 'user', 'warehouse', 'headquarter'])->find($inventory->id)),
            'message' => 'Inventario completado correctamente y stock actualizado',
            'error' => 0
        ]);
    }

    /**
     * Helper to update ProductStock and Batch stock when physical inventory is completed.
     */
    private function consolidateProductStock($user, int $warehouseId, Product $product, float $physicalStock, float $difference, string $docRef): void
    {
        if ($product->requiere_lote) {
            $activeBatches = Batch::where('id_producto', $product->id)
                ->where(function ($q) use ($warehouseId) {
                    $q->where('warehouse_id', $warehouseId)
                      ->orWhereNull('warehouse_id');
                })
                ->where('estado', 1)
                ->orderBy('fecha_vencimiento', 'asc')
                ->get();

            if ($activeBatches->isNotEmpty()) {
                $currentBatchTotal = $activeBatches->sum('stock_actual');
                $adjDiff = $physicalStock - $currentBatchTotal;
                $lastBatch = $activeBatches->last();
                $lastBatch->stock_actual = max(0, $lastBatch->stock_actual + $adjDiff);
                if ($lastBatch->stock_actual <= 0) {
                    $lastBatch->estado = 5; // Agotado
                }
                $lastBatch->save();
            } else {
                Batch::create([
                    'company_id' => $user->company_id,
                    'warehouse_id' => $warehouseId,
                    'id_producto' => $product->id,
                    'in_date' => now()->toDateString(),
                    'fecha_vencimiento' => now()->addDays($product->vida_util ?: 30)->toDateString(),
                    'stock_actual' => $physicalStock,
                    'estado' => $physicalStock > 0 ? 1 : 5,
                ]);
            }
        }

        // Always update ProductStock for this warehouse
        ProductStock::updateOrCreate(
            [
                'company_id' => $user->company_id,
                'warehouse_id' => $warehouseId,
                'product_id' => $product->id,
            ],
            ['stock_actual' => $physicalStock]
        );

        // ONLY Register Inventory Adjustment Movement IF an actual change occurred (difference != 0)
        if (abs($difference) > 0.0001) {
            MovimientoInventario::create([
                'company_id' => $user->company_id,
                'id_lote' => null,
                'id_producto' => $product->id,
                'warehouse_id' => $warehouseId,
                'tipo_movimiento' => 4, // Ajuste_Inventario
                'cantidad' => $difference,
                'saldo' => $physicalStock,
                'fecha_movimiento' => now(),
                'documento_referencia' => $docRef,
                'usuario_id' => $user->id,
            ]);
        }
    }
}
