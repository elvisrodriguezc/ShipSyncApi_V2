<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductaccesoryResource extends JsonResource
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
            'accesory' => [
                'id' => $this->accesory->id,
                'name' => $this->accesory->name,
                'unity' => new UnityResource($this->accesory->unity),
                'price' => (float)$this->accesory->price,
            ],
            'unity' => new UnityResource($this->unity),
            'quantity' => $this->quantity,
            'price' => (float)$this->price,
            'status' => $this->status,
        ];
    }
}
