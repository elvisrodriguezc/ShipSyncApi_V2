<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProducttaxResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product' => $this->product->name,
            'tax_id' => $this->tax_id,
            'tax' => $this->tax->name,
            'rate' => $this->rate,
            'value' => $this->value,
            'status' => $this->status,
        ];
    }
}
