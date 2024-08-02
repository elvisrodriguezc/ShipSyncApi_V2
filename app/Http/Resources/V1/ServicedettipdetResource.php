<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicedettipdetResource extends JsonResource
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
            "servicedettip_id" => $this->servicedettip_id,
            "usuario" => [
                "id" => (int)$this->user->id,
                "name" => $this->user->name,
                "user" => $this->user->user,
            ],
            "amount" => (float)$this->amount,
            "status" => $this->status,
        ];
    }
}
