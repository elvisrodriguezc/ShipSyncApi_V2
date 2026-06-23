<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovimientoInventario;
use App\Models\Product;
use App\Services\BatchStockService;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $companyId = $user->company_id;

        $products = Product::where('company_id', $companyId)
            ->with('category')
            ->get();

        $result = [];

        $warehouseId = $request->query('warehouse_id');
        $productId = $request->query('product_id');

        if ($productId) {
            $products = $products->where('id', $productId);
        }

        $batchService = new BatchStockService();

        foreach ($products as $product) {
            $movQuery = MovimientoInventario::where('company_id', $companyId)
                ->whereNull('deleted_at');

            if ($warehouseId) {
                $movQuery->where('warehouse_id', $warehouseId);
            }

            if (!$product->requiere_lote) {
                $ultimoSaldo = (clone $movQuery)
                    ->where('id_producto', $product->id)
                    ->max('saldo') ?? 0;

                $result[] = [
                    'producto_id' => $product->id,
                    'producto_nombre' => $product->name,
                    'requiere_lote' => false,
                    'categoria_id' => $product->category_id,
                    'categoria_nombre' => $product->category->name ?? '',
                    'stock' => (float) $ultimoSaldo,
                    'lote_id' => null,
                    'lote_numero' => null,
                    'lote_fecha_vencimiento' => null,
                    'es_mas_antiguo' => false,
                ];
            } else {
                $batches = $batchService->getBatchesForProduct($companyId, $product->id, $warehouseId);

                if (empty($batches)) {
                    $ultimoSaldo = (clone $movQuery)
                        ->where('id_producto', $product->id)
                        ->max('saldo') ?? 0;

                    $result[] = [
                        'producto_id' => $product->id,
                        'producto_nombre' => $product->name,
                        'requiere_lote' => true,
                        'categoria_id' => $product->category_id,
                        'categoria_nombre' => $product->category->name ?? '',
                        'stock' => (float) $ultimoSaldo,
                        'lote_id' => null,
                        'lote_numero' => null,
                        'lote_fecha_vencimiento' => null,
                        'es_mas_antiguo' => false,
                    ];
                } else {
                    foreach ($batches as $batch) {
                        $result[] = [
                            'producto_id' => $product->id,
                            'producto_nombre' => $product->name,
                            'requiere_lote' => true,
                            'categoria_id' => $product->category_id,
                            'categoria_nombre' => $product->category->name ?? '',
                            'stock' => $batch['stock'],
                            'lote_id' => $batch['lote_id'],
                            'lote_numero' => $batch['lote_numero'],
                            'lote_fecha_vencimiento' => $batch['lote_fecha_vencimiento'],
                            'es_mas_antiguo' => $batch['es_mas_antiguo'],
                        ];
                    }
                }
            }
        }

        return response()->json($result);
    }
}
