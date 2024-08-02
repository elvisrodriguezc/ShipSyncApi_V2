<?php

namespace App\Http\Resources\V1;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'value' => (int)$this->id,
            'label' => $this->name,
            'name' => $this->name,
            'detail' => $this->detail,
            'office' => [
                'id' => $this->office->id,
                'company_id' => $this->office->company_id,
                'company' => $this->office->company->name,
                'name' => $this->office->name,
                'address' => $this->office->address,
                'phone' => $this->office->phone,
                'email' => $this->office->email,
            ],
            'warehouseParent' => new WarehouseResource($this->warehouse),
            'isproduction' => $this->isproduction === 1 ? 'Producción' : 'No es de Producción',
            'status' => $this->status,
        ];
    }
}
