<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicedettipResource extends JsonResource
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
            "servicedetail_id" => $this->servicedetail_id,
            'detalle' => new ServicedettipdetCollection($this->servicedettipdet),
            "typevalue_id" => $this->id,
            "razon" => $this->typevalue->name,
            "note" => $this->note,
            "status" => $this->status,
        ];
    }
}
