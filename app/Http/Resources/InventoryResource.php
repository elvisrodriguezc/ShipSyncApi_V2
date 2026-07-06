<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'company_id' => $this->company_id,
            'company' => $this->company ? $this->company->name : null,
            'date' => $this->date,
            'headquarter_id' => $this->headquarter_id,
            'headquarter' => HeadquarterResource::make($this->headquarter),
            'warehouse_id' => $this->warehouse_id,
            'warehouse' => WarehouseResource::make($this->warehouse),
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->user),
            'numerator_id' => $this->numerator_id,
            'serie' => $this->numerator?->serial,
            'number' => $this->number,
            'items' => InventoryItemResource::collection($this->items),
            'notes' => $this->notes,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
