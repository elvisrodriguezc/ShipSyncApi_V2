<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypevalueResource extends JsonResource
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
            'type_id' => $this->type_id,
            'type' => $this->type->name,
            'value' => $this->id,
            'label' => $this->name,
            'name' => $this->name,
            'value_data' => $this->value,
            'description' => $this->description,
            'abbreviation' => $this->abbreviation,
            'status' => $this->status,
        ];
    }
}
