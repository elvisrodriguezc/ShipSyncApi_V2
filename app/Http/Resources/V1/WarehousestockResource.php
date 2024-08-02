<?php

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehousestockResource extends JsonResource
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
            "office_id" => $this->office_id,
            "office_name" => $this->office->name,
            "warehouse_id" => $this->warehouse_id,
            "warehouse_name" => $this->warehouse->name,
            "product_id" => $this->product_id,
            "label" => $this->product->name,
            "value" => $this->product->id,
            "product" => new ProductResource($this->product),
            "stock" => (float) $this->stock,
            "price" => (float) $this->price,
            "reserved" => (float)$this->reserved,
            "infinity" => $this->infinity,
            "created_at" => $this->created_at->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}
