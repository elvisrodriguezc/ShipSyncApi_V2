<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductaddonResource extends JsonResource
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
            'addon' => [
                'id' => $this->addon->id,
                'name' => $this->addon->name,
                'unity' => new UnityResource($this->addon->unity),
                'price' => (float)$this->addon->price,
            ],
            'status' => $this->status,
        ];
    }
}
