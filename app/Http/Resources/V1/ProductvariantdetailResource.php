<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductvariantdetailResource extends JsonResource
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
            "productvariant_id" => $this->productvariant_id,
            "typevalue_id" => $this->typevalue_id,
            "value" => $this->typevalue_id,
            "name" => $this->typevalue->name,
            "valor" => $this->typevalue->valor,
            "label" => $this->typevalue->name,
            "type_id" => $this->typevalue->type->id,
            "type" => $this->typevalue->type->name,
            "status" => $this->status,
        ];
    }
}
