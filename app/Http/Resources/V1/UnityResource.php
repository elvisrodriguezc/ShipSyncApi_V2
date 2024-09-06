<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnityResource extends JsonResource
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
            'label' => $this->name,
            "typeunity" => [
                "id" => $this->typevalues->id,
                "name" => $this->typevalues->name,
            ],
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'valor' => $this->value,
            'status' => $this->status,
        ];
    }
}
