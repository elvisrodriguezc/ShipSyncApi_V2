<?php

namespace App\Http\Resources\V1;

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
            'id' => (int)$this->id,
            'company_id' => $this->company_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'idform' => [
                'doc' => $this->idform->abbrev,
                'number' => $this->idform_number,
            ],
            'region' => $this->ubigeodistrito->ubigeoprovincia->ubigeodepartamento->name,
            'provincia' => $this->ubigeodistrito->ubigeoprovincia->name,
            'distrito' => $this->ubigeodistrito->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'remark' => $this->remark,
            'value' => (int)$this->id,
            'label' => $this->company_name,
            'branches' => new EntitiebranchCollection($this->entitiebranches),
        ];
    }
}
