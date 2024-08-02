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
            'label' => $this->name,
            'value' => $this->id,
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'valor' => $this->value,
            'status' => $this->status,
            // 'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            // 'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
