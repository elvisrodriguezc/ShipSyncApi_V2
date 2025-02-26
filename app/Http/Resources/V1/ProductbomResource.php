<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductbomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'product_id' => $this->product_id,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'barcode' => $this->product->barcode,
                'price' => (float)$this->product->price,
            ],
            'bom_id' => $this->bom_id,
            'bom' => [
                'id' => $this->bom->id,
                'name' => $this->bom->name,
                'barcode' => $this->bom->barcode,
                'price' => (float)$this->bom->price,
            ],
            'unity' => new UnityResource($this->unity),
            'quantity' => $this->quantity,
            'price' => (float)$this->price,
            'status' => $this->status,
        ];
    }
}
