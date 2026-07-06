<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
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
            'inventory_id' => $this->inventory_id,
            'product_id' => $this->product_id,
            'product' => ProductResource::make($this->product),
            'system_stock' => $this->system_stock,
            'physical_stock' => $this->physical_stock,
            'difference' => $this->difference,
            'observation' => $this->observation,
        ];
    }
}
