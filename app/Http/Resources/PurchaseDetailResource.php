<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'product' => $this->product?->name,
            'requiere_lote' => $this->product ? (bool)$this->product->requiere_lote : false,
            'vida_util' => $this->product ? (int)$this->product->vida_util : 0,
            'cantidad' => (float) $this->cantidad,
            'id_lote' => $this->id_lote,
            'costo_unitario' => $this->costo_unitario ? (float) $this->costo_unitario : null,
            'batch' => $this->whenLoaded('batch', fn() => [
                'id_lote' => $this->batch->id_lote,
                'fecha_vencimiento' => $this->batch->fecha_vencimiento,
            ]),
        ];
    }
}
