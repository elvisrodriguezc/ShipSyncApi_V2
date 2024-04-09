<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'entity_id' => $this->entity_id,
            'ruc' => $this->ruc,
            'name' => $this->company_id,
            'matricula' => $this->matricula,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'color' => $this->color,
            'aniofabricacion' => $this->aniofabricacion,
            'tuc' => $this->tuc,
            'observaciones' => $this->observaciones,
            'image' => $this->image,
            'status' => $this->status,
            'value' => $this->id,
            'label' => $this->matricula,
        ];
    }
}
