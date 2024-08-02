<?php

namespace App\Http\Resources\V1;

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
            'id' => (int)$this->id,
            'type_id' => $this->type->id,
            'type' => $this->type->name,
            'name' => $this->name,
            'valor' => $this->value,
            'abbrev' => $this->abbrev,
            'value' => (int)$this->id,
            'label' => $this->name,
            'status' => $this->status,
        ];
    }
}
