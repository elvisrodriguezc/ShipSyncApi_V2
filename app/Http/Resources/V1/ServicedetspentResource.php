<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicedetspentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'servicedetail_id' => $this->servicedetail_id,
            'ruc' => $this->ruc,
            'serie' => $this->serie,
            'number' => $this->number,
            'amount' => $this->amount,
            'detail' => $this->detail,
            'typecpe_id' => $this->typecpe_id,
            'typecpe' => $this->typecpe,
            'status' => $this->status,
        ];
    }
}
