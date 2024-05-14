<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
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
            'user' => [
                "id" => $this->user->id,
                "name" => $this->user->name,
                "user" => $this->user->user,
            ],
            'serie' => $this->numerator->serie,
            'number' => $this->number,
            'startdate' => $this->startdate,
            'finishdate' => $this->finishdate,
            'status' => $this->status,
            'date' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
