<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\MovimientoInventario;
use App\Models\Product;

class BatchStockService
{
    public function getBatchesForProduct(int $companyId, int $productId, ?int $warehouseId = null): array
    {
        $product = Product::find($productId);

        if (!$product || !$product->requiere_lote) {
            return [];
        }

        $batches = Batch::where('company_id', $companyId)
            ->where('id_producto', $productId)
            ->get();

        $batchItems = [];
        foreach ($batches as $batch) {
            if ($warehouseId) {
                $ultimoSaldo = MovimientoInventario::where('company_id', $companyId)
                    ->whereNull('deleted_at')
                    ->where('id_producto', $productId)
                    ->where('id_lote', $batch->id_lote)
                    ->where('warehouse_id', $warehouseId)
                    ->max('saldo') ?? 0;
            } else {
                $ultimoSaldo = $batch->stock_actual ?? 0;
            }

            $batchItems[] = [
                'lote_id' => $batch->id_lote,
                'lote_numero' => 'Lote #' . $batch->id_lote,
                'lote_fecha_vencimiento' => $batch->fecha_vencimiento,
                'stock' => (float) $ultimoSaldo,
                'batch' => $batch,
            ];
        }

        $oldestFecha = null;
        $oldestBatchId = null;
        foreach ($batchItems as $item) {
            if ($item['stock'] > 0 && $item['lote_fecha_vencimiento']) {
                if ($oldestFecha === null || $item['lote_fecha_vencimiento'] < $oldestFecha) {
                    $oldestFecha = $item['lote_fecha_vencimiento'];
                    $oldestBatchId = $item['lote_id'];
                }
            }
        }

        $result = [];
        foreach ($batchItems as $item) {
            $result[] = [
                'lote_id' => $item['lote_id'],
                'lote_numero' => $item['lote_numero'],
                'lote_fecha_vencimiento' => $item['lote_fecha_vencimiento'],
                'stock' => $item['stock'],
                'es_mas_antiguo' => $item['lote_id'] === $oldestBatchId,
            ];
        }

        return $result;
    }
}
