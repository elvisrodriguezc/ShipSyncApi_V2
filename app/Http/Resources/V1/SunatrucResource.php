<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SunatrucResource extends JsonResource
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
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'estado' => $this->estado,
            'ubigeo' => $this->ubigeo,
            'tipo_via' => $this->tipo_via,
            'nombre_via' => $this->nombre_via,
            'codigo_zona' => $this->codigo_zona,
            'numero' => $this->numero,
            'interior' => $this->interior,
            'lote' => $this->lote,
            'departamento' => $this->departamento,
            'manzana' => $this->manzana,
            'kilometro' => $this->kilometro,
        ];
    }
}
