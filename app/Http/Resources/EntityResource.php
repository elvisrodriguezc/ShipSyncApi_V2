<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
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
            'label' => $this->razon_social,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'mode' => $this->mode,
            'ruc' => $this->ruc,
            'razón_social' => $this->razon_social,
            'estado' => $this->estado,
            'condición' => $this->condición,
            'ubigeo' => $this->ubigeo,
            'tipo_via' => $this->tipo_via,
            'nombre_via' => $this->nombre_via,
            'codigo_zona' => $this->codigo_zona,
            'tipo_zona' => $this->tipo_zona,
            'numero' => $this->numero,
            'interior' => $this->interior,
            'lote' => $this->lote,
            'departamento' => $this->departamento,
            'manzana' => $this->manzana,
            'kilometro' => $this->kilometro,
            'status' => $this->status,
        ];
    }
}
