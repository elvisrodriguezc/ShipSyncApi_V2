<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'label' => $this->name,
            'value' => $this->id,
            'valuex' => (float) $this->value,
            'company_id' => $this->company_id,
            'company' => $this->company->name,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'status' => $this->status,
        ];
    }
}
