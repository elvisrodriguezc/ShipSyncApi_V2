<?php

namespace App\Http\Resources\V1;

use App\Models\Servicedetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResource extends JsonResource
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
            'company_id' => $this->company_id,
            'date' => $this->date,
            'serie' => $this->numerator->serie,
            'number' => $this->number,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'role' => $this->user->role
            ],
            'entity' => [
                'id' =>  $this->entity->id,
                'company_name' => $this->entity->company_name
            ],
            'note' => $this->note,
            'status' => $this->status,
            'detail' => new ServicedetailCollection($this->Servicedetail),
        ];
    }
}
