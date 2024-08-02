<?php

namespace App\Http\Resources\V1;

use App\Models\Guidecarrieritem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuidecarrierResource extends JsonResource
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
            "company_id" => $this->company_id,
            "company" => [
                "id" => $this->company->id,
                "ruc" => $this->company->ruc,
                "name" => $this->company->name,
                "address" => $this->company->address,
                "registromtc" => $this->company->registromtc,
            ],
            "tipocpe" => 31,
            "user_id" => $this->user_id,
            "numerator_id" => $this->numerator->id,
            "serie" => $this->numerator->serie,
            "numberF" => str_pad($this->number, 5, '0', STR_PAD_LEFT),
            "number" => $this->number,
            "release_date" => substr($this->release_date, 0, 10),
            "transfer_date" => $this->transfer_date,
            "sender_id" => $this->sender_id,
            "sender" => [
                "name" => $this->sender->company_name,
                "numberid" => $this->sender->idform_number,
                "codeid" => $this->sender->idform->value,
            ],
            "senderbranch_id" => $this->senderbranch_id,
            "senderbranch" => [
                "address" => $this->senderbranch->address,
                "ubigeo" => $this->senderbranch->ubigeodistrito->ubigeo,
                "distrito" => $this->senderbranch->ubigeodistrito->name,
                "provincia" => $this->senderbranch->ubigeodistrito->ubigeoprovincia->name,
                "region" => $this->senderbranch->ubigeodistrito->ubigeoprovincia->ubigeodepartamento->name,
            ],
            "destination_id" => $this->destination_id,
            "destination" => [
                "name" => $this->destination->company_name,
                "numberid" => $this->destination->idform_number,
                "codeid" => $this->destination->idform->value,
            ],
            "destinationbranch_id" => $this->destinationbranch_id,
            "destinationbranch" => [
                "address" => $this->destinationbranch->address,
                "ubigeo" => $this->destinationbranch->ubigeodistrito->ubigeo,
                "distrito" => $this->destinationbranch->ubigeodistrito->name,
                "provincia" => $this->destinationbranch->ubigeodistrito->ubigeoprovincia->name,
                "region" => $this->destinationbranch->ubigeodistrito->ubigeoprovincia->ubigeodepartamento->name,
            ],
            "driver_id" => $this->driver_id,
            "driver" => [
                "name" => $this->driver->name,
                "lastname" => $this->driver->lastname,
                'doctipo' =>  $this->driver->typevalue->name,
                'doctipocod' =>  $this->driver->typevalue->value,
                'documento' => $this->driver->documento,
                "licence" => $this->driver->licence,
                "licencecategory" => $this->driver->licencecategory,
            ],
            "vehicle_id" => $this->vehicle_id,
            "vehicle" => [
                "ruc" => $this->vehicle->ruc,
                "name" => $this->vehicle->name,
                "matricula" => $this->vehicle->matricula,
                "marca" => $this->vehicle->marca,
                "tuc" => $this->vehicle->tuc,
            ],
            "tercero_id" => $this->tercero_id,
            "tercero" => [
                "name" => $this->tercero?->company_name,
                "ruc" => $this->tercero?->idform_number,
            ],
            "subcontratado_id" => $this->subcontratado_id,
            "subcontratado" => [
                "name" => $this->subcontratado?->company_name,
                "ruc" => $this->subcontratado?->idform_number,
            ],
            "tipoindicador_id" => $this->tipoindicador_id,
            "tipoindicador" => $this->tipoindicador?->name,
            "pesobruto" => $this->pesobruto,
            "nota" => $this->nota,
            "numTicket" => $this->numTicket,
            "fecRecepcion" => $this->fecRecepcion,
            "codRespuesta" => $this->codRespuesta,
            "indCdrGenerado" => $this->indCdrGenerado,
            "numError" => $this->numError,
            "desError" => $this->desError,
            "hash" => $this->hash,
            "filename" => $this->filename,
            "status" => (int)$this->status,
            'items' => new GuidecarrieritemCollection($this->items),
            'documents' => new GuidecarrierdocsCollection($this->documents),
            "createdatdate" => $this->created_at?->format('Y-m-d'),
            "createdattime" => $this->created_at?->format('H:i:s'),
            "updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
