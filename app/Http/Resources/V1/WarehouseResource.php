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
            'name' => $this->name,
            'detail' => $this->detail,
            'office' => [
                'id' => $this->office->id,
                'name' => $this->office->name,
                'address' => $this->office->address,
                'phone' => $this->office->phone,
                'email' => $this->office->email,
            ],
            'whParent_id' => $this->warehouse_id,
            'isproduction' => $this->isproduction === 1 ? 'Producción' : 'No es de Producción',
            'status' => $this->status,

        ];
    }
}
