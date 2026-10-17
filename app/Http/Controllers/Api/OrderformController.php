<?php

namespace App\Http\Controllers\Api;

use App\Events\AlertTriggered;
use App\Events\OrderformEvent;
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

        $query = Orderform::where('company_id', $company_id)->with([
            'company',
            'headquarter',
            'warehouse',
            'user.role',
            'user.headquarter',
            'user.warehouse',
            'contact',
            'orderformitems.product',
            'orderformitems.unit',
            'orderformitems.orderformitemcomments'
        ]);

        // Filter by user role or permissions: sadmin, pfadmin, admin and pfproducer see all; or anyone with orderforms.edit/delete permissions
        if (
            !in_array($user->role->slug, ['sadmin', 'pfadmin', 'admin', 'producer', 'pfproducer']) &&
            !$user->hasPermission('orderforms.edit') &&
            !$user->hasPermission('orderforms.delete')
        ) {
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

        $status = $user->autoaprobar ? 2 : 1;
        $request->merge(['status' => $status]);

        $orderform = new Orderform($request->all());
        $orderform->save();
        $orderform->orderformitems()->createMany($request->orderItems);

        $orderform->load('orderformitems.product');
        OrderformEvent::dispatch($orderform, 'created');

        return OrderformResource::make($orderform)->additional([
            'message' => 'Orden de pedido creada correctamente',
            'error' => 0,
        ]);
    }

    public function approve(Request $request, $id)
    {
        $user = auth()->user();
        $orderform = Orderform::where('company_id', $user->company_id)->findOrFail($id);

        $isAdmin = in_array($user->role->slug, ['sadmin', 'pfadmin', 'admin']) || $user->hasPermission('orderforms.edit');

        if (!$isAdmin) {
            // Regular user can only edit their own order
            if ($orderform->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Acceso denegado. No eres el creador de este pedido.',
                    'error' => 1
                ], 403);
            }
            // Regular user can only edit if status is Pendiente (1)
            if ((int) $orderform->status !== 1) {
                return response()->json([
                    'message' => 'Acceso denegado. Solo puedes editar pedidos en estado Pendiente.',
                    'error' => 1
                ], 403);
            }
        }

        if (!in_array((int) $orderform->status, [1, 2])) {
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

            // Delete items that were removed in the frontend and release their stock reservations
            $removedIds = $orderform->orderformitems()->whereNotIn('id', $keptIds)->pluck('id');
            if ($removedIds->isNotEmpty()) {
                \App\Models\StockReservation::whereIn('orderformitem_id', $removedIds)->update(['status' => 0]);
                $orderform->orderformitems()->whereNotIn('id', $keptIds)->delete();
            }

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
        OrderformEvent::dispatch($orderform, 'approved');

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

                $this->deductProductStock($user, $orderform, $product, (float) $item->quantity, $despachados);

                // Update stock reservation status to 2 (Consumed)
                \App\Models\StockReservation::where('orderformitem_id', $item->id)->update(['status' => 2]);
            }

            $orderform->update([
                'status' => 3, // 3: Atendido
                'finished_at' => now(),
            ]);
        });

        $orderform->load('orderformitems.product');
        OrderformEvent::dispatch($orderform, 'attended');

        return response()->json([
            'message' => 'Pedido atendido y despachado de inventario correctamente',
            'data' => [
                'orderform' => OrderformResource::make($orderform),
                'despachados' => $despachados
            ],
            'error' => 0
        ]);
    }

    public function reopen(Request $request, $id)
    {
        $user = auth()->user();
        $orderform = Orderform::where('company_id', $user->company_id)->findOrFail($id);

        $canReopen = in_array($user->role->slug, ['sadmin', 'pfadmin', 'admin', 'pfproducer']) || $user->hasPermission('orderforms.edit');

        if (!$canReopen) {
            return response()->json([
                'message' => 'No tienes permisos para reabrir este pedido',
                'error' => 1
            ], 403);
        }

        if (!in_array((int) $orderform->status, [3, 4])) {
            return response()->json([
                'message' => 'Solo se pueden reabrir pedidos que estén en estado Atendido o Anulado',
                'error' => 1
            ], 422);
        }

        DB::transaction(function () use ($orderform, $user) {
            // If reopening from status 3 (Atendido), revert physical stock deductions
            if ((int) $orderform->status === 3) {
                foreach ($orderform->orderformitems as $item) {
                    $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                    if ($product->requiere_lote) {
                        // Find movements registered for this order's attendance
                        $movements = MovimientoInventario::where('warehouse_id', $orderform->warehouse_id)
                            ->where('id_producto', $item->product_id)
                            ->where('tipo_movimiento', 2) // Egreso_Venta
                            ->where('documento_referencia', 'Salida por Orden de Producción #' . $orderform->id)
                            ->get();

                        if ($movements->isNotEmpty()) {
                            foreach ($movements as $mov) {
                                $quantityToRevert = abs($mov->cantidad);
                                $batch = null;

                                if ($mov->id_lote) {
                                    $batch = \App\Models\Batch::find($mov->id_lote);
                                    if ($batch) {
                                        $batch->stock_actual += $quantityToRevert;
                                        if ($batch->stock_actual > 0 && $batch->estado == 5) {
                                            $batch->estado = 1; // Re-activate batch if it was marked exhausted
                                        }
                                        $batch->save();
                                    }
                                }

                                // Register inverse/reversal movement
                                MovimientoInventario::create([
                                    'company_id' => $orderform->company_id,
                                    'id_lote' => $mov->id_lote,
                                    'id_producto' => $item->product_id,
                                    'warehouse_id' => $orderform->warehouse_id,
                                    'tipo_movimiento' => 3, // Ingreso_Ajuste por Reapertura
                                    'cantidad' => $quantityToRevert,
                                    'saldo' => $batch ? $batch->stock_actual : $product->getStockActual($orderform->warehouse_id),
                                    'fecha_movimiento' => now(),
                                    'documento_referencia' => 'Reapertura de Orden de Pedido #' . $orderform->id,
                                    'usuario_id' => $user->id,
                                ]);
                            }
                        } else {
                            // Fallback if movement record was missing: restore item quantity on latest batch
                            $latestBatch = \App\Models\Batch::where('id_producto', $item->product_id)
                                ->where(function ($q) use ($orderform) {
                                    $q->where('warehouse_id', $orderform->warehouse_id)
                                        ->orWhereNull('warehouse_id');
                                })
                                ->orderBy('id_lote', 'desc')
                                ->first();

                            if ($latestBatch) {
                                $latestBatch->stock_actual += $item->quantity;
                                if ($latestBatch->stock_actual > 0 && $latestBatch->estado == 5) {
                                    $latestBatch->estado = 1;
                                }
                                $latestBatch->save();
                            }

                            MovimientoInventario::create([
                                'company_id' => $orderform->company_id,
                                'id_lote' => $latestBatch ? $latestBatch->id_lote : null,
                                'id_producto' => $item->product_id,
                                'warehouse_id' => $orderform->warehouse_id,
                                'tipo_movimiento' => 3,
                                'cantidad' => $item->quantity,
                                'saldo' => $latestBatch ? $latestBatch->stock_actual : $item->quantity,
                                'fecha_movimiento' => now(),
                                'documento_referencia' => 'Reapertura de Orden de Pedido #' . $orderform->id,
                                'usuario_id' => $user->id,
                            ]);
                        }
                    } else {
                        // Revert non-lot product stock in ProductStock
                        $prodStock = \App\Models\ProductStock::firstOrCreate(
                            [
                                'company_id' => $orderform->company_id,
                                'warehouse_id' => $orderform->warehouse_id,
                                'product_id' => $item->product_id,
                            ],
                            ['stock_actual' => 0]
                        );
                        $prodStock->increment('stock_actual', $item->quantity);

                        MovimientoInventario::create([
                            'company_id' => $orderform->company_id,
                            'id_lote' => null,
                            'id_producto' => $item->product_id,
                            'warehouse_id' => $orderform->warehouse_id,
                            'tipo_movimiento' => 3, // Ingreso por Reapertura
                            'cantidad' => $item->quantity,
                            'saldo' => $prodStock->stock_actual,
                            'fecha_movimiento' => now(),
                            'documento_referencia' => 'Reapertura de Orden de Pedido #' . $orderform->id,
                            'usuario_id' => $user->id,
                        ]);
                    }
                }
            }

            // Re-activate stock reservations for all items in the order
            \App\Models\StockReservation::where('orderform_id', $orderform->id)
                ->update(['status' => 1]); // 1: Active Reservation

            // Update order status back to 2 (Admitido) and clear finished_at
            $orderform->update([
                'status' => 2, // 2: Admitido
                'finished_at' => null,
            ]);
        });

        $orderform->load('orderformitems.product');
        OrderformEvent::dispatch($orderform, 'reopened');

        return response()->json([
            'message' => 'Orden de pedido reabierta correctamente. Se restituyó el stock y se reactivó la reserva.',
            'data' => OrderformResource::make($orderform),
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

        if ($orderform->status != 1 && !(($orderform->status == 2 || $orderform->status == 1) && (int) $request->input('status') === 4)) {
            return response()->json([
                'message' => 'No se puede modificar una orden que ya no está pendiente',
                'error' => 1
            ], 422);
        }

        $orderform->update($request->all());
        $orderform->load('orderformitems.product');
        OrderformEvent::dispatch($orderform, 'updated');

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
        $user = auth()->user();
        $orderform = Orderform::where('company_id', $user->company_id)->findOrFail($id);

        if (!in_array((int) $orderform->status, [1, 2])) {
            return response()->json([
                'message' => 'No se puede eliminar una orden que ya está atendida o anulada',
                'error' => 1
            ], 422);
        }

        // Validate delete permission or admin/sadmin/pfadmin roles
        $canDelete = in_array($user->role->slug, ['sadmin', 'pfadmin', 'admin']) || $user->hasPermission('orderforms.delete');
        if (!$canDelete) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar esta orden',
                'error' => 1
            ], 403);
        }

        $orderId = $orderform->id;

        // Delete items one-by-one to trigger Eloquent deleted event (OrderformitemObserver)
        foreach ($orderform->orderformitems as $item) {
            $item->delete();
        }
        $orderform->delete();

        OrderformEvent::dispatch($orderId, 'deleted');

        return response()->json([
            'message' => 'Orden de pedido eliminada correctamente',
            'error' => 0
        ]);
    }

    /**
     * Deducts stock for a product from a warehouse.
     * If product stock is insufficient (or 0) and stockdependency_id is set, deducts remaining quantity from dependent product.
     */
    private function deductProductStock($user, Orderform $orderform, Product $product, float $quantityNeeded, array &$despachados, string $reasonSuffix = ''): void
    {
        $currentStock = $product->getStockActual($orderform->warehouse_id);

        if ($currentStock > 0) {
            $deductFromPrimary = min($currentStock, $quantityNeeded);
            $this->executeSingleProductDeduction($user, $orderform, $product, $deductFromPrimary, $despachados, $reasonSuffix);
            $remainingNeeded = $quantityNeeded - $deductFromPrimary;
        } else {
            $remainingNeeded = $quantityNeeded;
        }

        // If remaining quantity needed > 0 and product has a stockdependency_id
        if ($remainingNeeded > 0 && $product->stockdependency_id) {
            $dependentProduct = Product::where('id', $product->stockdependency_id)->lockForUpdate()->first();
            if ($dependentProduct) {
                $depSuffix = ' (por dependencia de ' . $product->name . ')' . $reasonSuffix;
                $this->deductProductStock($user, $orderform, $dependentProduct, $remainingNeeded, $despachados, $depSuffix);
                $remainingNeeded = 0;
            }
        }

        // If still remaining needed (e.g. no dependent product set or dependent product didn't fully cover it), deduct whatever remains from primary product (allowing negative stock/batch creation if needed)
        if ($remainingNeeded > 0) {
            $this->executeSingleProductDeduction($user, $orderform, $product, $remainingNeeded, $despachados, $reasonSuffix);
        }
    }

    /**
     * Executes single product stock deduction (handling lot products vs non-lot products).
     */
    private function executeSingleProductDeduction($user, Orderform $orderform, Product $product, float $quantity, array &$despachados, string $reasonSuffix = ''): void
    {
        if ($quantity <= 0)
            return;

        if ($product->requiere_lote) {
            // FEFO deduction from active and unexpired batches for this warehouse
            $batches = \App\Models\Batch::where('id_producto', $product->id)
                ->where(function ($q) use ($orderform) {
                    $q->where('warehouse_id', $orderform->warehouse_id)
                        ->orWhereNull('warehouse_id');
                })
                ->where('estado', 1) // Activo
                ->where('fecha_vencimiento', '>=', now()->toDateString())
                ->lockForUpdate()
                ->orderBy('fecha_vencimiento', 'asc')
                ->get();

            if ($batches->isEmpty()) {
                // Find any batch or create default batch
                $anyBatch = \App\Models\Batch::where('id_producto', $product->id)
                    ->where(function ($q) use ($orderform) {
                        $q->where('warehouse_id', $orderform->warehouse_id)
                            ->orWhereNull('warehouse_id');
                    })
                    ->lockForUpdate()
                    ->orderBy('id_lote', 'desc')
                    ->first();

                if (!$anyBatch) {
                    $anyBatch = \App\Models\Batch::create([
                        'company_id' => $orderform->company_id,
                        'warehouse_id' => $orderform->warehouse_id,
                        'id_producto' => $product->id,
                        'fecha_vencimiento' => now()->addDays(30)->toDateString(),
                        'estado' => 5, // Agotado
                        'stock_actual' => 0
                    ]);
                }
                $batches = collect([$anyBatch]);
            }

            $remaining = $quantity;
            $totalBatches = $batches->count();
            $index = 0;

            foreach ($batches as $batch) {
                $index++;
                if ($remaining <= 0)
                    break;

                $deduct = ($index === $totalBatches) ? $remaining : min($batch->stock_actual, $remaining);

                $batch->stock_actual -= $deduct;
                $batch->estado = ($batch->stock_actual <= 0) ? 5 : 1;
                $batch->save();

                MovimientoInventario::create([
                    'company_id' => $orderform->company_id,
                    'id_lote' => $batch->id_lote,
                    'id_producto' => $product->id,
                    'warehouse_id' => $orderform->warehouse_id,
                    'tipo_movimiento' => 2, // Egreso_Venta
                    'cantidad' => -1 * $deduct,
                    'saldo' => $batch->stock_actual,
                    'fecha_movimiento' => now(),
                    'documento_referencia' => 'Salida por Orden de Producción #' . $orderform->id . $reasonSuffix,
                    'usuario_id' => $user->id,
                ]);

                $despachados[] = [
                    'producto' => $product->name . $reasonSuffix,
                    'lote_id' => $batch->id_lote,
                    'fecha_vencimiento' => $batch->fecha_vencimiento,
                    'cantidad' => $deduct,
                ];

                $remaining -= $deduct;
            }
        } else {
            // Non-lot product: deduct directly from ProductStock for this warehouse
            $prodStock = \App\Models\ProductStock::firstOrCreate(
                [
                    'company_id' => $orderform->company_id,
                    'warehouse_id' => $orderform->warehouse_id,
                    'product_id' => $product->id,
                ],
                ['stock_actual' => 0]
            );
            $prodStock->decrement('stock_actual', $quantity);

            MovimientoInventario::create([
                'company_id' => $orderform->company_id,
                'id_lote' => null,
                'id_producto' => $product->id,
                'warehouse_id' => $orderform->warehouse_id,
                'tipo_movimiento' => 2, // Egreso_Venta
                'cantidad' => -1 * $quantity,
                'saldo' => $prodStock->fresh()->stock_actual,
                'fecha_movimiento' => now(),
                'documento_referencia' => 'Salida por Orden de Producción #' . $orderform->id . $reasonSuffix,
                'usuario_id' => $user->id,
            ]);

            $despachados[] = [
                'producto' => $product->name . $reasonSuffix,
                'lote_id' => null,
                'fecha_vencimiento' => null,
                'cantidad' => $quantity,
            ];
        }
    }
}
