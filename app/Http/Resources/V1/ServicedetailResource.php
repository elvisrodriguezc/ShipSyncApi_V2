<?php

namespace App\Http\Resources\V1;

use App\Models\Servicedetail;
use App\Models\Servicedettip;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicedetailResource extends JsonResource
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
            'serie' => $this->numerator->serie,
            'number' => $this->number,
            'initkm' => $this->initkm,
            'finalkm' => $this->finalkm,
            'initkmGPS' => $this->initkmGPS,
            'finalkmGPS' => $this->finalkmGPS,
            'tripLength' => $this->tripLength,
            'servicio' => $this->typevalue->name,
            'program' => [
                'id' => $this->services->id,
                'date' => $this->services->date,
                'serie' => $this->services->numerator->serie,
                'number' => $this->services->number,
            ],
            'typevalue' => [
                'id' => $this->typevalue->id,
                'name' => $this->typevalue->name
            ],
            'vehicle' => [
                'id' => $this->vehicle->id,
                'denominacion' => $this->vehicle->denominacion,
                'matricula' => $this->vehicle->matricula,
            ],
            'personal' => new ServicedetastCollection($this->servicedetast),
            'documentos' => new ServicedetdocCollection($this->servicedetdoc),
            'spents' => new ServicedetspentCollection($this->servicedetspent),
            'adicionales' => new ServicedettipCollection($this->servicedettip),
            'recorrido' => $this->tripLength,
            'status' => $this->status
        ];
    }
}
