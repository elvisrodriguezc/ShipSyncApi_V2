<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
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
            'percentage-based' => $this->percentage_based,
            'sunat_code' => $this->sunat_code,
            'sunat_namecode' => $this->sunat_namecode,
            'name' => $this->name,
            'rate' => $this->rate,
            'value' => $this->value,
            'description' => $this->description,
            'operationtype_id' => $this->operationtype_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ];
    }
}
