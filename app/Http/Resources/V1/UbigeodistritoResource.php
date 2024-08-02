<?php

namespace App\Http\Resources\V1;

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
            'id' => (int)$this->id,
            'value' => (int)$this->id,
            'label' => $this->ubigeoprovincia->ubigeodepartamento->code . $this->ubigeoprovincia->code . $this->code . ' ' . $this->name,
            'label' => $this->name,
            'code' => $this->code,
            'name' => $this->name,
            'provincia' => [
                'id' => $this->ubigeoprovincia->id,
                'name' => $this->ubigeoprovincia->name,
                'code' => $this->ubigeoprovincia->code,
                'region' => [
                    'id' => $this->ubigeoprovincia->ubigeodepartamento->id,
                    'name' => $this->ubigeoprovincia->ubigeodepartamento->name,
                    'code' => $this->ubigeoprovincia->ubigeodepartamento->code,
                ]
            ],
            'poblacion' => $this->poblacion,
            'superficie' => $this->superficie,
            'latitud' => $this->x,
            'longitud' => $this->y,
        ];
    }
}
