<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntitiebranchResource extends JsonResource
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
            "value" => $this->id,
            "entity_id" => $this->entity_id,
            "ubigeodistrito_id" => $this->ubigeodistrito_id,
            "ubigeo" => $this->ubigeodistrito->ubigeo,
            "distrito" => $this->ubigeodistrito->name,
            "provincia" => $this->ubigeodistrito->ubigeoprovincia->name,
            "region" => $this->ubigeodistrito->ubigeoprovincia->ubigeodepartamento->name,
            "address" => $this->address,
            "label" => $this->address,
            "phone" => $this->phone,
            "latitud" => $this->latitud,
            "longitud" => $this->longitud,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
