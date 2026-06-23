<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\MovimientoInventario;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Purchase::where('company_id', $user->company_id);

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('startdate')) {
            $query->whereDate('fecha_ingreso', '>=', $request->startdate);
        }
        if ($request->filled('enddate')) {
            $query->whereDate('fecha_ingreso', '<=', $request->enddate);
        }

        $data = $query->with('details.product', 'details.batch')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return PurchaseResource::collection($data);
    }

    public function store(StorePurchaseRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'warehouse_id' => $data['warehouse_id'],
            'entity_id' => $data['entity_id'],
            'tipo_comprobante' => $data['tipo_comprobante'],
            'numero_comprobante' => $data['numero_comprobante'],
            'fecha_emision' => $data['fecha_emision'],
            'fecha_ingreso' => $data['fecha_ingreso'],
            'peso_bruto' => $data['peso_bruto'] ?? 0,
            'status' => 1, // 1: Pendiente
        ]);

        foreach ($data['details'] as $detail) {
            PurchaseDetail::create([
                'purchase_id' => $purchase->id,
                'product_id' => $detail['product_id'],
                'cantidad' => $detail['cantidad'],
                'costo_unitario' => $detail['costo_unitario'] ?? null,
            ]);
        }

        $purchase->load('details.product');
        return PurchaseResource::make($purchase);
    }

    public function receive(Request $request, $id)
    {
        $user = auth()->user();
        $purchase = Purchase::where('company_id', $user->company_id)->findOrFail($id);

        if ($purchase->status == 2) {
            return response()->json([
                'message' => 'Esta compra ya ha sido recibida anteriormente',
                'error' => 1
            ], 422);
        }

        $request->validate([
            'details' => 'required|array',
            'details.*.purchase_detail_id' => 'required|exists:purchase_details,id',
            'details.*.fecha_vencimiento' => 'nullable|date',
        ]);

        $detailsInput = collect($request->input('details'))->keyBy('purchase_detail_id');

        DB::transaction(function () use ($purchase, $detailsInput, $user) {
            foreach ($purchase->details as $detail) {
                $product = $detail->product;
                $input = $detailsInput->get($detail->id);

                if ($product->requiere_lote) {
                    if (!$input || empty($input['fecha_vencimiento'])) {
                        throw new \Illuminate\Validation\ValidationException(
                            \Validator::make([], []),
                            response()->json(['message' => "La fecha de vencimiento es obligatoria para el producto: {$product->name}"], 422)
                        );
                    }

                    // Create batch
                    $batch = \App\Models\Batch::create([
                        'company_id' => $purchase->company_id,
                        'id_producto' => $detail->product_id,
                        'in_date' => now()->toDateString(),
                        'fecha_vencimiento' => $input['fecha_vencimiento'],
                        'stock_actual' => $detail->cantidad,
                        'estado' => 1,
                    ]);

                    $detail->update(['id_lote' => $batch->id_lote]);

                    // Positive movement for batch
                    MovimientoInventario::create([
                        'company_id' => $purchase->company_id,
                        'id_lote' => $batch->id_lote,
                        'id_producto' => $detail->product_id,
                        'warehouse_id' => $purchase->warehouse_id,
                        'tipo_movimiento' => 1, // Ingreso_Compra
                        'cantidad' => $detail->cantidad,
                        'saldo' => $detail->cantidad,
                        'fecha_movimiento' => now(),
                        'documento_referencia' => $purchase->numero_comprobante,
                        'usuario_id' => $user->id,
                    ]);
                } else {
                    // Non-lot item: calculate latest running saldo for the product in this warehouse
                    $lastMov = MovimientoInventario::where('warehouse_id', $purchase->warehouse_id)
                        ->where('id_producto', $detail->product_id)
                        ->orderBy('id_movimiento', 'desc')
                        ->first();
                    $ultimoSaldo = $lastMov ? $lastMov->saldo : 0;

                    MovimientoInventario::create([
                        'company_id' => $purchase->company_id,
                        'id_lote' => null,
                        'id_producto' => $detail->product_id,
                        'warehouse_id' => $purchase->warehouse_id,
                        'tipo_movimiento' => 1, // Ingreso_Compra
                        'cantidad' => $detail->cantidad,
                        'saldo' => (float) $ultimoSaldo + (float) $detail->cantidad,
                        'fecha_movimiento' => now(),
                        'documento_referencia' => $purchase->numero_comprobante,
                        'usuario_id' => $user->id,
                    ]);
                }

                // Increment global product stock cache
                $product->increment('stock', $detail->cantidad);
            }

            $purchase->update(['status' => 2]); // 2: Recibido
        });

        $purchase->load('details.product', 'details.batch');
        return PurchaseResource::make($purchase)->additional([
            'message' => 'Compra recibida y stock registrado correctamente',
            'error' => 0
        ]);
    }

    public function show($id)
    {
        $purchase = Purchase::where('company_id', auth()->user()->company_id)->findOrFail($id);
        $purchase->load('details.product', 'details.batch');
        return PurchaseResource::make($purchase);
    }

    public function update(UpdatePurchaseRequest $request, $id)
    {
        $user = auth()->user();
        $data = $request->validated();
        $purchase = Purchase::where('company_id', $user->company_id)->findOrFail($id);

        if ($purchase->status == 2) {
            return response()->json([
                'message' => 'No se puede modificar una compra que ya ha sido recibida',
                'error' => 1
            ], 422);
        }

        $purchase->update($data);

        if (isset($data['details'])) {
            $purchase->details()->delete();

            foreach ($data['details'] as $detail) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $detail['product_id'],
                    'cantidad' => $detail['cantidad'],
                    'costo_unitario' => $detail['costo_unitario'] ?? null,
                ]);
            }
        }

        $purchase->load('details.product', 'details.batch');
        return PurchaseResource::make($purchase);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $purchase = Purchase::where('company_id', $user->company_id)->findOrFail($id);

        if ($purchase->status == 2) {
            // Revert stock changes
            DB::transaction(function () use ($purchase, $user) {
                foreach ($purchase->details as $detail) {
                    $product = $detail->product;

                    if ($detail->id_lote) {
                        $batch = \App\Models\Batch::find($detail->id_lote);
                        if ($batch) {
                            // Register reversal movement (negative adjustment)
                            MovimientoInventario::create([
                                'company_id' => $purchase->company_id,
                                'id_lote' => $batch->id_lote,
                                'id_producto' => $detail->product_id,
                                'warehouse_id' => $purchase->warehouse_id,
                                'tipo_movimiento' => 4, // Ajuste
                                'cantidad' => -1 * $detail->cantidad,
                                'saldo' => 0, // batch is being undone
                                'fecha_movimiento' => now(),
                                'documento_referencia' => 'Reversión por eliminación de compra ' . $purchase->numero_comprobante,
                                'usuario_id' => $user->id,
                            ]);
                            $batch->delete();
                        }
                    } else {
                        $lastMov = MovimientoInventario::where('warehouse_id', $purchase->warehouse_id)
                            ->where('id_producto', $detail->product_id)
                            ->orderBy('id_movimiento', 'desc')
                            ->first();
                        $ultimoSaldo = $lastMov ? $lastMov->saldo : 0;

                        MovimientoInventario::create([
                            'company_id' => $purchase->company_id,
                            'id_lote' => null,
                            'id_producto' => $detail->product_id,
                            'warehouse_id' => $purchase->warehouse_id,
                            'tipo_movimiento' => 4, // Ajuste
                            'cantidad' => -1 * $detail->cantidad,
                            'saldo' => (float) $ultimoSaldo - (float) $detail->cantidad,
                            'fecha_movimiento' => now(),
                            'documento_referencia' => 'Reversión por eliminación de compra ' . $purchase->numero_comprobante,
                            'usuario_id' => $user->id,
                        ]);
                    }

                    $product->decrement('stock', $detail->cantidad);
                }
            });
        }

        $purchase->details()->delete();
        $purchase->delete();
        return response()->json(['message' => 'Compra eliminada correctamente', 'error' => 0]);
    }
}
