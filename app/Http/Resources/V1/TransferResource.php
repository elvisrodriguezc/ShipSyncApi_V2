<?php

namespace App\Http\Resources\V1;

use App\Models\Transferdetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
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
            "user_id" => $this->user_id,
            "numerator_id" => $this->numerator_id,
            "numerator" => [
                "id" => $this->numerator?->id,
                "serie" => $this->numerator?->serie,
            ],
            "number" => $this->number,
            "originwarehouse_id" => $this->originwarehouse_id,
            "originwarehouse" => [
                "id" => $this->originwarehouse?->id,
                "name" => $this->originwarehouse?->name,
                "detail" => $this->originwarehouse?->detail,
            ],
            "destinationwarehouse_id" => $this->destinationwarehouse_id,
            "destinationwarehouse" => [
                "id" => $this->destinationwarehouse?->id,
                "name" => $this->destinationwarehouse?->name,
                "detail" => $this->destinationwarehouse?->detail,
            ],
            "receivinguser_id" => $this->receivinguser_id,
            "receivinguser" => [
                "id" => $this->receivinguser?->id,
                "name" => $this->receivinguser?->name,
                "apellido" => $this->receivinguser?->lastname,
            ],
            "detail" => $this->detail,
            'items' => new TransferdetailCollection($this->items),
            "status" => $this->status,
            "created_at" => $this->created_at?->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at?->format("Y-m-d H:i:s"),
        ];
    }
}
