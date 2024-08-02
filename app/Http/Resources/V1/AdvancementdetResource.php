<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvancementdetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'advancement_id' => $this->advancement_id,
            'updatedby_id' => $this->user_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'payroll_id' =>  $this->payroll_id,
            'updatedby' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'role' => $this->user?->role,
            ],
            'status' => $this->status,
        ];
    }
}
