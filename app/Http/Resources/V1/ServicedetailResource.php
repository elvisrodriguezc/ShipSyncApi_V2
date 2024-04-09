<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicedetailResource extends JsonResource
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
            'typevalue' => [
                'id' => $this->typevalue->id,
                'name' => $this->typevalue->name
            ],
            'vehicle' => [
                'id' => $this->vehicle->id,
                'denominacion' => $this->vehicle->denominacion,
                'matricula' => $this->vehicle->matricula,
            ],
            'folios' => $this->vehicle->folios,
            'status' => $this->vehicle->status
        ];
    }
}
