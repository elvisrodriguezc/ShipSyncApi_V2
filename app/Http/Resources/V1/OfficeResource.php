<?php

namespace App\Http\Resources\V1;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'company_id' => (int)$this->company_id,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'distrito' => new UbigeodistritoResource($this->ubigeodistrito),
            'warehouses' => WarehouseResource::collection($this->warehouse)
        ];
    }
}
