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
            "office_id" => $this->office_id,
            "office" => [
                "id" => $this->office->id,
                "name" => $this->office->name,
                "company_id" => $this->office->company_id,
                "company" => $this->office->company->name,
            ],
            "documenttype_id" => $this->documenttype_id,
            "serie" => $this->serie,
            "number" => $this->number,
            "description" => $this->description,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
