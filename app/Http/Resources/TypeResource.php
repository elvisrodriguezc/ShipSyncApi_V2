<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
            'company' => $this->company->name,
            'name' => $this->name,
            'description' => $this->description,
            'typevalues' => TypevalueResource::collection($this->typevalues),
            'status' => $this->status,
        ];
    }
}
