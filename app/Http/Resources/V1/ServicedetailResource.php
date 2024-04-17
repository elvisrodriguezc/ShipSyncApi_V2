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
            'serie' => $this->numerator->serie,
            'number' => $this->number,
            'program' => [
                'id' => $this->services->id,
                'date' => $this->services->date,
                'serie' => $this->services->numerator->serie,
                'number' => $this->services->number,
            ],
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
            'personal' => new ServicedetastCollection($this->Servicedetast),
            'status' => $this->vehicle->status
        ];
    }
}
