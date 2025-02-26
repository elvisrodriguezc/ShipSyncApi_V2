<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VcandidateResource extends JsonResource
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
            'company_id' => (int)$this->company_id,
            'user_id' => (int)$this->user_id,
            'dni' => $this->dni,
            'name' => $this->name,
            'detail' => $this->detail,
            'image' => $this->image,
            'position' => $this->position,
            'status' => $this->status,
            'company' => [
                "id" => $this->company->id,
                "name" => $this->company->name,
            ],
            'user' => [
                "id" => $this->user->id,
                "name" => $this->user->name,
            ],
        ];
    }
}
