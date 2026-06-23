<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->id,
            'label' => $this->razon_social,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'mode' => $this->mode,
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'ubigeo' => $this->ubigeo,
            'address' => $this->address,
            'status' => $this->status,
        ];
    }
}
