<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UbigeodistritoResource extends JsonResource
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
            'value' => $this->id,
            'label' => $this->name,
            'name' => $this->name,
            'code' => $this->code,
            'province_id' => $this->ubigeoprovincia_id,
            'province' => UbigeoprovinciaResource::make($this->ubigeoprovincia),

        ];
    }
}
