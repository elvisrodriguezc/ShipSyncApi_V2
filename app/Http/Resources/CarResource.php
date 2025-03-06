<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'value' => $this->id,
            'label' => $this->name . ' - ' . $this->plate,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'entity_id' => $this->entity_id,
            'entity' => $this->entity,
            'name' => $this->name,
            'description' => $this->description,
            'plate' => $this->plate,
            'color' => $this->color,
            'model' => $this->model,
            'year' => $this->year,
            'chassis' => $this->chassis,
            'tuc' => $this->tuc,
            'image' => $this->image,
            'status' => $this->status,
        ];
    }
}
