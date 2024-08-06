<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferdetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (int) $this->id,
            "transfer_id" => $this->transfer_id,
            "product_id" => $this->product_id,
            "product" => [
                "id" => $this->product->id,
                "name" => $this->product->name,
                "unity_id" => $this->product->unity->id,
                "unity" => $this->product->unity->name,
                "unity_valor" => $this->product->unity->value,
                "model" => $this->product->model,
                "brand" => $this->product->brand->name,
                "category" => $this->product->category->text,
            ],
            "unity_id" => $this->unity_id,
            "unity" => [
                "id" => $this->unity->id,
                "name" => $this->unity->name,
                "valor" => $this->unity->value,
            ],
            "quantity" => $this->quantity,
            "quantityreceived" => $this->quantityreceived,
            "comments" => $this->comments,
            "receivinguser_id" => $this->receivinguser_id,
            "receivinguser" => [
                "id" => $this->receivinguser?->id,
                "name" => $this->receivinguser?->name,
                "lastname" => $this->receivinguser?->lastname,
            ],
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
