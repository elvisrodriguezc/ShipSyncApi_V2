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
            'idform_id' => $this->idform_id,
            'idform_number' => $this->idform_number,
            'phone' => $this->phone,
            'email' => $this->email,
            'ubigeodistrito_id' => $this->ubigeodistrito_id,
            'address' => $this->address,
            'remark' => $this->remark,
        ];
    }
}
