<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuidecarrieritemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "guidecarrier_id" => $this->id,
            "product" => [
                "id" => $this->product->id,
                "name" => $this->product->name,
            ],
            "quantity" => $this->quantity,
            "unity" => [
                "id" => $this->unity->id,
                "name" => $this->unity->name,
                "abbreviation" => $this->unity->abbreviation,
            ],
            "unitvalue" => $this->unitvalue,
            "discount" => $this->duscount,
            "mto_baseigv" => $this->mto_baseigv,
            "porcentaje_igv" => $this->porcentaje_igv,
            "total_impuestos" => $this->total_impuestos,
            "monto_preciounitario" => $this->monto_preciounitario,
            "status" => $this->status,
        ];
    }
}
