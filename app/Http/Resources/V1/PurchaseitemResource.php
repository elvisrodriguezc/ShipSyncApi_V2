<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseitemResource extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'product' => [
                'id' => $this->products->id,
                'name' => $this->products->name,
                'detail' => $this->products->detail,
                'unity' => $this->products->unity->name,
                'unity_id' => $this->products->unity->id,
                'abbreviation' => $this->products->unity->abbreviation,
                'value' => $this->products->unity->value,
            ],
            'unity_id' => $this->unity_id,
            'unity' => [
                'id' => $this->unities->id,
                'abbreviation' => $this->unities->abbreviation,
                'name' => $this->unities->name,
                'value' => $this->unities->value,
            ],
            'price' => $this->price,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'discount_percent' => $this->discount_percent,
            'status' => $this->status,
        ];
    }
}
