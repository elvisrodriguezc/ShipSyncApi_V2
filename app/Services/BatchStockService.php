<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Product;

class BatchStockService
{
    public function getBatchesForProduct(int $companyId, int $productId, ?int $warehouseId = null): array
    {
        $product = Product::find($productId);

        if (!$product || !$product->requiere_lote) {
            return [];
        }

        $query = Batch::where('company_id', $companyId)
            ->where('id_producto', $productId)
            ->where('stock_actual', '>', 0);

        if ($warehouseId) {
            $query->where(function ($q) use ($warehouseId) {
                $q->where('warehouse_id', $warehouseId)
                    ->orWhereNull('warehouse_id');
            });
        }

        $batches = $query->get();

        $batchItems = [];
        foreach ($batches as $batch) {
            $stockActual = $batch->stock_actual ?? 0;

            $batchItems[] = [
                'lote_id' => $batch->id_lote,
                'lote_numero' => 'Lote #' . $batch->id_lote,
                'lote_fecha_vencimiento' => $batch->fecha_vencimiento,
                'stock' => (float) $stockActual,
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
