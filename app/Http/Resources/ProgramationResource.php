<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramationResource extends JsonResource
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
            'company' => $this->company,
            'numerator_id' => $this->numerator_id,
            'numerator' => $this->numerator,
            'number' => $this->number,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'customer_id' => $this->customer_id,
            'customer' => $this->customer,
            'date' => $this->date,
            'note' => $this->note,
            'status' => $this->status,
        ];
    }
}
