<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_lote' => $this->id_lote,
            'company_id' => $this->company_id,
            'id_producto' => $this->id_producto,
            'product_name' => $this->product?->name ?? '—',
            'warehouse_name' => $this->warehouse?->name ?? '—',
            'product' => $this->product ? [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'code' => $this->product->code ?? null,
                'unidad' => $this->product->unit->symbol ?? '—',
                'category_id' => $this->product->category_id,
                'category_name' => $this->product->category?->name ?? '—',
            ] : null,
            'numero_lote_proveedor' => $this->numero_lote_proveedor,
            'purchase_id' => $this->purchase_id,
            'purchase' => $this->purchase ? [
                'id' => $this->purchase->id,
                'numero_comprobante' => $this->purchase->numero_comprobante,
                'tipo_comprobante' => $this->purchase->tipo_comprobante,
            ] : null,
            'in_date' => $this->in_date,
            'fecha_fabricacion' => $this->fecha_fabricacion,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'stock_inicial' => (float) $this->stock_inicial,
            'stock_actual' => (float) $this->stock_actual,
            'estado' => $this->estado,
            'movements' => MovimientoInventarioResource::collection($this->whenLoaded('movements')),
        ];
    }
}
