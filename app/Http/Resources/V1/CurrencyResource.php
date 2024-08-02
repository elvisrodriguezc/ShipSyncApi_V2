<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'name' => ucwords($this->name),
            'label' => ucwords($this->name),
            'symbol' => $this->symbol,
            'rate' => $this->rate,
            'status' => $this->status,
        ];
    }
}
