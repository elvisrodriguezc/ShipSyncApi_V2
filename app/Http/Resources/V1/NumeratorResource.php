<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NumeratorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "office" => $this->office,
            "document" => $this->document,
            "serie" => $this->serie,
            "number" => $this->number,
            "description" => $this->description,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
