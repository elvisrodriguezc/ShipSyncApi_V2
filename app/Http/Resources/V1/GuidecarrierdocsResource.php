<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuidecarrierdocsResource extends JsonResource
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
            "ruc" => $this->ruc,
            "serie" => $this->serie,
            "number" =>  str_pad($this->number, 5, '0', STR_PAD_LEFT),
            "tipocpe_name" => $this->tipocpe->name,
            "tipocpe_code" => $this->tipocpe->value,
            "tipocpe" => [
                "id" => $this->tipocpe->id,
                "name" => $this->tipocpe->name,
                "value" => $this->tipocpe->value,
            ],
            "status" => $this->status,
        ];
    }
}
