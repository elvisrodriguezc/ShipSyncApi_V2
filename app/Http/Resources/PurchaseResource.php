<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->user?->name,
            'company_id' => $this->company_id,
            'warehouse_id' => $this->warehouse_id,
            'warehouse' => $this->warehouse?->name,
            'entity_id' => $this->entity_id,
            'entity' => $this->entity?->razon_social,
            'tipo_comprobante' => $this->tipo_comprobante,
            'numero_comprobante' => $this->numero_comprobante,
            'fecha_emision' => $this->fecha_emision,
            'fecha_ingreso' => $this->fecha_ingreso,
            'peso_bruto' => (float) $this->peso_bruto,
            'status' => $this->status,
            'details' => PurchaseDetailResource::collection($this->whenLoaded('details')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
