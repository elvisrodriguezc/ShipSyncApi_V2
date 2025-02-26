<?php

namespace App\Http\Resources\V1;

use App\Models\Tariff;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
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
            'value' => (int)$this->id,
            'name' => $this->name,
            'label' => $this->name,
            'office_id' => $this->office_id,
            'office' => [
                "id" => $this->office->id,
                "name" => $this->office->name,
            ],
            'currency' => [
                "name" => $this->currency->name,
                "symbol" => $this->currency->symbol,
                "rate" => $this->currency->rate,
                "id" => $this->currency->id,
            ],
            'rate' => $this->rate,
            'status' => $this->status,
            'items' => TariffitemResource::collection($this->tariffitem),
        ];
    }
}
