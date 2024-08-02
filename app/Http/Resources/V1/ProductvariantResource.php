<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductvariantResource extends JsonResource
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
            "value" => $this->id,
            "label" => $this->variants->pluck('typevalue.name')->implode(', '),
            "product_id" => $this->product_id,
            // "product" => [
            //     "id" => $this->product->id,
            //     "name" => $this->product->name,
            // ],
            "sku" => $this->sku,
            "price" => $this->price,
            "image" => $this->image,
            "variantdetails" => ProductvariantdetailResource::collection($this->variants),
            "status" => $this->status,
            "created_at" => $this->created_at?->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at?->format("Y-m-d H:i:s"),
        ];
    }
}
