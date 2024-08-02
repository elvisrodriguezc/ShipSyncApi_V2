<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicedetdocResource extends JsonResource
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
            'servicedetail_id' => $this->servicedetail_id,
            'tipoDocId' => $this->typevalue_id,
            'tipoDoc' => $this->typevalue->name,
            'serie' => $this->serie,
            'number' => $this->number,
            'distrito_id' => $this->ubigeodistrito_id,
            'distrito' => $this->ubigeodistrito->name,
            'note' => $this->note,
        ];
    }
}
