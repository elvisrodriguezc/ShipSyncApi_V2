<?php

namespace App\Http\Resources\V1;

use App\Models\Productvariant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequirementdetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                "id" => $this->id,
                "requirement_id" => $this->requirement_id,
                "product_id" => $this->product_id,
                "product" => new ProductResource($this->product),
                "productvariant_id" => $this->productvariant_id,
                "productvariant" => new ProductvariantResource($this->productvariant),
                "nonexistent" => $this->nonexistent,
                "detail" => $this->detail,
                "unity_id" => $this->unity_id,
                "quantity" => $this->quantity,
                "updatedby_id" => $this->updatedby_id,
                "status" => $this->status,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at
            ];
    }
}
