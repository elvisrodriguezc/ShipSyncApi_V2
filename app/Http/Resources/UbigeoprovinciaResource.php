<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UbigeoprovinciaResource extends JsonResource
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
            'ubigeodepartamento_id' => $this->ubigeodepartamento_id,
            'department' => UbigeodepartamentoResource::make($this->ubigeodepartamento),
        ];
    }
}
