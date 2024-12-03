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
            'company_id' => (int)$this->company_id,
            'date' => $this->date,
            'serie' => $this->numerator->serie,
            'number' => (int)$this->number,
            'user' => $this->user,
            'entity' => $this->entity,
            'note' => $this->note,
            'servicios' => new ServicedetailCollection($this->Servicedetail),
            'status' => (int) $this->status,
        ];
    }
}
