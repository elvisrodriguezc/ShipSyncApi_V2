<?php

namespace App\Http\Controllers\Api;

use App\Events\AlertTriggered;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderformRequest;
use App\Http\Requests\UpdateOrderformRequest;
use App\Http\Resources\OrderformResource;
use App\Models\Orderform;
use App\Models\Orderformitem;
use App\Models\Product;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'startdate' => 'required|date',
            'enddate' => 'sometimes|date',
        ]);
        if (!$request->has('startdate')) {
            return response()->json([
                'message' => 'La fecha de inicio es obligatoria',
                'error' => 1,
            ], 400);
        }
        
        $user = auth()->user();
        $company_id = $user->company_id;
        
        $query = Orderform::where('company_id', $company_id);
        
        // Filter by user role: sadmin, pfadmin and pfproducer see all; other roles see only their own
        if (!in_array($user->role->slug, ['sadmin', 'pfadmin', 'pfproducer'])) {
            $query->where('user_id', $user->id);
        }
        
        if ($request->has('enddate')) {
            $query->whereDate('date', '>=', $request->startdate)
                  ->whereDate('date', '<=', $request->enddate);
        } else {
            $query->whereDate('date', '>=', $request->startdate);
        }
        
        $data = $query->orderBy('id', 'desc')->get();
        
        return OrderformResource::collection($data)
            ->additional([
                'meta' => [
                    'message' => 'Listado de ordenes de pedido',
                    'total' => $data->count(),
                ]
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderformRequest $request)
    {
        $user = auth()->user();
        $request->validated();

        $request->merge(['finished_at' => null]);
        $request->merge(['company_id' => $user->company_id]);
        $request->merge(['headquarter_id' => $user->headquarter_id]);
        $request->merge(['warehouse_id' => $user->warehouse_id]);
        $request->merge(['user_id' => $user->id]);
        
        $status = 1; // 1: Pendiente
        if (in_array($user->role->slug, ['sadmin', 'pfadmin'])) {
            $status = 2; // 2: Admitido/Aprobado
        }
        $request->merge(['status' => $status]);

        $orderform = new Orderform($request->all());
        $orderform->save();
        $orderform->orderformitems()->createMany($request->orderItems);

        $orderform->load('orderformitems.product');
        return OrderformResource::make($orderform)->additional([
            'message' => 'Orden de pedido creada correctamente',
            'error' => 0,
        ]);
    }

    public function approve(Request $request, $id)
    {
        $user = auth()->user();
        $orderform = Orderform::where('company_id', $user->company_id)->findOrFail($id);

        $isAdmin = in_array($user->role->slug, ['sadmin', 'pfadmin']);

        if (!$isAdmin) {
            // Regular user can only edit their own order
            if ($orderform->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Acceso denegado. No eres el creador de este pedido.',
                    'error' => 1
                ], 403);
            }
            // Regular user can only edit if status is Pendiente (1)
            if ((int)$orderform->status !== 1) {
                return response()->json([
                    'message' => 'Acceso denegado. Solo puedes editar pedidos en estado Pendiente.',
                    'error' => 1
                ], 403);
            }
        }

        if (!in_array((int)$orderform->status, [1, 2])) {
            return response()->json([
                'message' => 'Solo se pueden editar/aprobar pedidos en estado Pendiente o Admitido',
                'error' => 1
            ], 422);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'nullable|exists:orderformitems,id',
            'items.*.product_id' => 'required_without:items.*.id|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.weight' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($orderform, $request, $user) {
            $submittedItems = $request->input('items');

            // Find all item IDs that are being kept/updated
            $keptIds = collect($submittedItems)->pluck('id')->filter()->all();

            // Delete items that were removed in the frontend
            $orderform->orderformitems()->whereNotIn('id', $keptIds)->delete();

            // Update existing items or create new ones
            foreach ($submittedItems as $itemData) {
                if (!empty($itemData['id'])) {
                    $item = $orderform->orderformitems()->findOrFail($itemData['id']);
                    $item->update([
                        'quantity' => $itemData['quantity'],
                        'weight' => $itemData['weight'] ?? 0,
                    ]);
                } else {
                    $product = \App\Models\Product::where('company_id', $user->company_id)
                        ->findOrFail($itemData['product_id']);

                    $orderform->orderformitems()->create([
                        'product_id' => $product->id,
                        'quantity' => $itemData['quantity'],
                        'weight' => $itemData['weight'] ?? 0,
                        'unit_id' => $product->unit_id,
                        'unit_price' => $product->price ?? 0,
                        'status' => 1,
                    ]);
                }
            }

            $orderform->update(['status' => 2]); // 2: Admitido
        });

        $orderform->load('orderformitems.product');
        return OrderformResource::make($orderform)->additional([
            'message' => 'Pedido procesado correctamente',
            'error' => 0
        ]);
    }

    public function attend(Request $request, $id)
    {
        $user = auth()->user();
        $orderform = Orderform::where('company_id', $user->company_id)->findOrFail($id);

        if ($orderform->status != 2) {
            return response()->json([
                'message' => 'Solo se pueden despachar/atender pedidos que estén en estado Admitido',
                'error' => 1
            ], 422);
        }

        $despachados = [];

        DB::transaction(function () use ($orderform, $user, &$despachados) {
            foreach ($orderform->orderformitems as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if ($product->requiere_lote) {
                    // FEFO deduction from active and unexpired batches
                    $batches = \App\Models\Batch::where('id_producto', $item->product_id)
                        ->where('estado', 1) // Activo
                        ->where('fecha_vencimiento', '>=', now()->toDateString())
                        ->lockForUpdate()
                        ->orderBy('fecha_vencimiento', 'asc')
                        ->get();

                    if ($batches->isEmpty()) {
                        // Try to find any existing batch for this product to log the negative stock
                        $anyBatch = \App\Models\Batch::where('id_producto', $item->product_id)
                            ->lockForUpdate()
                            ->orderBy('id_lote', 'desc')
                            ->first();

                        if (!$anyBatch) {
                            // If no batch exists, create a default one
                            $anyBatch = \App\Models\Batch::create([
                                'company_id' => $orderform->company_id,
                                'id_producto' => $item->product_id,
                                'fecha_vencimiento' => now()->addDays(30)->toDateString(),
                                'estado' => 5, // Agotado
                                'stock_actual' => 0
                            ]);
                        }
                        $batches = collect([$anyBatch]);
                    }

                    $remaining = $item->quantity;
                    $totalBatches = $batches->count();
                    $index = 0;

                    foreach ($batches as $batch) {
                        $index++;
                        if ($remaining <= 0) break;

                        // If it's the last batch, we deduct all the remaining required quantity from it
                        // even if it causes the batch stock to go negative.
                        if ($index === $totalBatches) {
                            $deduct = $remaining;
                        } else {
                            $deduct = min($batch->stock_actual, $remaining);
                        }

                        $batch->stock_actual -= $deduct;
                        if ($batch->stock_actual <= 0) {
                            $batch->estado = 5; // 5: Agotado
                        } else {
                            $batch->estado = 1; // 1: Activo
                        }
                        $batch->save();

                        // Register movement
                        MovimientoInventario::create([
                            'company_id' => $orderform->company_id,
                            'id_lote' => $batch->id_lote,
                            'id_producto' => $item->product_id,
                            'warehouse_id' => $orderform->warehouse_id,
                            'tipo_movimiento' => 2, // Egreso_Venta
                            'cantidad' => -1 * $deduct,
                            'saldo' => $batch->stock_actual,
                            'fecha_movimiento' => now(),
                            'documento_referencia' => 'Salida por Orden de Producción #' . $orderform->id,
                            'usuario_id' => $user->id,
                        ]);

                        $despachados[] = [
                            'producto' => $product->name,
                            'lote_id' => $batch->id_lote,
                            'fecha_vencimiento' => $batch->fecha_vencimiento,
                            'cantidad' => $deduct,
                        ];

                        $remaining -= $deduct;
                    }
                } else {
                    // Non-lot product: deduct directly allowing negative stock
                    $lastMov = MovimientoInventario::where('warehouse_id', $orderform->warehouse_id)
                        ->where('id_producto', $item->product_id)
                        ->orderBy('id_movimiento', 'desc')
                        ->first();
                    $ultimoSaldo = $lastMov ? $lastMov->saldo : 0;

                    MovimientoInventario::create([
                        'company_id' => $orderform->company_id,
                        'id_lote' => null,
                        'id_producto' => $item->product_id,
                        'warehouse_id' => $orderform->warehouse_id,
                        'tipo_movimiento' => 2, // Egreso_Venta
                        'cantidad' => -1 * $item->quantity,
                        'saldo' => (float)$ultimoSaldo - (float)$item->quantity,
                        'fecha_movimiento' => now(),
                        'documento_referencia' => 'Salida por Orden de Producción #' . $orderform->id,
                        'usuario_id' => $user->id,
                    ]);

                    $despachados[] = [
                        'producto' => $product->name,
                        'lote_id' => null,
                        'fecha_vencimiento' => null,
                        'cantidad' => $item->quantity,
                    ];
                }

                // Decrement global stock cache (allows negative values)
                $product->decrement('stock', $item->quantity);
            }

            $orderform->update([
                'status' => 3, // 3: Atendido
                'finished_at' => now(),
            ]);
        });

        $orderform->load('orderformitems.product');
        return response()->json([
            'message' => 'Pedido atendido y despachado de inventario correctamente',
            'data' => [
                'orderform' => OrderformResource::make($orderform),
                'despachados' => $despachados
            ],
            'error' => 0
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orderform = Orderform::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $orderform->load('orderformitems.product');
        return OrderformResource::make($orderform);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderformRequest $request, $id)
    {
        $request->validated();
        $orderform = Orderform::where('company_id', auth()->user()->company_id)->findOrFail($id);

        if ($orderform->status != 1) {
            return response()->json([
                'message' => 'No se puede modificar una orden que ya no está pendiente',
                'error' => 1
            ], 422);
        }

        $orderform->update($request->all());

        return OrderformResource::make($orderform)->additional([
            'message' => 'Orden de pedido actualizada correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orderform = Orderform::where('company_id', auth()->user()->company_id)->findOrFail($id);

        if (!in_array((int)$orderform->status, [1, 2])) {
            return response()->json([
                'message' => 'No se puede eliminar una orden que ya está atendida o anulada',
                'error' => 1
            ], 422);
        }

        // Delete items one-by-one to trigger Eloquent deleted event (OrderformitemObserver)
        foreach ($orderform->orderformitems as $item) {
            $item->delete();
        }
        $orderform->delete();

        return response()->json([
            'message' => 'Orden de pedido eliminada correctamente',
            'error' => 0
        ]);
    }
}
