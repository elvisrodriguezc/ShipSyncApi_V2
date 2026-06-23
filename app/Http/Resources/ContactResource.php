<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (int)$this->id,
            "value" => (int)$this->id,
            "label" => $this->name,
            "company_id" => $this->company_id,
            "bussiness_name" => $this->bussiness_name,
            "bussiness_tipe_id" => $this->bussiness_tipe_id ? (int)$this->bussiness_tipe_id : null,
            "bussiness_tipe_name" => $this->bussinessTipe ? $this->bussinessTipe->name : null,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "status" => $this->status,
        ];
    }
}
