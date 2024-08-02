<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehousekardexResource extends JsonResource
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
            "company_id" => $this->company_id,
            "warehouse_id" => $this->warehouse_id,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,
            "product" => [
                "id" => $this->product->id,
                "name" => $this->product->name,
                "unity" => $this->product->unity->name,
            ],
            "unity_id" => $this->unity_id,
            "in" => $this->in,
            "out" => $this->out,
            "price" => $this->price,
            "prevstock" => $this->prevstock,
            "stock" => $this->stock,
            "purchaseitem_id" => $this->purchaseitem_id,
            "orderitem_id" => $this->orderitem_id,
            "transferitem_id" => $this->transferitem_id,
            "inventoryitem_id" => $this->inventoryitem_id,
            "detail" => $this->detail,
            "status" => $this->status,
            "created_at" => $this->created_at?->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at?->format("Y-m-d H:i:s"),
        ];
    }
}
