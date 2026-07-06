<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $warehouseId = $request->query('warehouse_id') ? (int) $request->query('warehouse_id') : (auth()->user()?->warehouse_id ?? null);
        $stockActual = $this->getStockActual($warehouseId);
        $stockReservado = $this->getStockReservado($warehouseId);
        $stockDisponible = $this->getStockDisponible($warehouseId);

        return [
            'id' => $this->id,
            'label' => strtoupper(number_format($stockActual, 0) . " " . $this->name),
            'value' => (int)$this->id,
            'company_id' => $this->company_id,
            'category_id' => $this->category_id,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name ?? '',
            ],
            'name' => $this->name,
            'codigo' => $this->codigo,
            'description' => $this->description,
            'peso' => $this->peso,
            'vida_util' => $this->vida_util,
            'requiere_lote' => (bool) $this->requiere_lote,
            'unit_id' => $this->unit_id,
            'price' => (float) $this->price,
            'stock' => (float) $stockActual,
            'stock_actual' => (float) $stockActual,
            'stock_reservado' => (float) $stockReservado,
            'stock_disponible' => (float) $stockDisponible,
            'stockdependency_id' => $this->stockdependency_id ? (int) $this->stockdependency_id : null,
            'stock_dependency' => $this->stockDependency ? [
                'id' => $this->stockDependency->id,
                'name' => $this->stockDependency->name,
            ] : null,
            'status' => $this->status,
        ];
    }
}
