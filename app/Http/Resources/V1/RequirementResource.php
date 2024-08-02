<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Metadata\Api\Requirements;

class RequirementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (int)$this->id,
            "warehouse" => [
                "id" => $this->warehouse->id,
                "name" => $this->warehouse->name,
            ],
            "user" => [
                "id" => (int)$this->user->id,
                "user" => $this->user->user,
                "name" => $this->user->name,
                "lastname" => $this->user->lastname,
            ],
            "numerator" => [
                "id" => (int)$this->numerator->id,
                "serie" => $this->numerator->serie,
            ],
            "number" => $this->number,
            "currency" => [
                "id" => (int)$this->currency->id,
                "name" => $this->currency->name,
                "symbol" => $this->currency->symbol,
                "rate" => $this->currency->rate,
            ],
            "relevance" => [
                "id" => $this->relevance->id,
                "name" => $this->relevance->name,
            ],
            "deadline" => $this->deadline,
            "updatedby_id" => $this->updatedby_id,
            "status" => (int) $this->status,
            "created_at" => $this->created_at,
            "created" => $this->created_at->format("Y-m-d"),
            "updated_at" => $this->updated_at,
            "updated" => $this->updated_at->format("Y-m-d"),
            'items' => RequirementdetailResource::collection($this->items),
        ];
    }
}
