<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_lote' => $this->id_lote,
            'company_id' => $this->company_id,
            'numero_lote_proveedor' => $this->numero_lote_proveedor,
            'in_date' => $this->in_date,
            'fecha_fabricacion' => $this->fecha_fabricacion,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'estado' => $this->estado,
        ];
    }
}
