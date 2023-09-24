<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashierdetailResource extends JsonResource
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
            'cashier_id' => $this->cashier_id,
            'paymethod_id' => $this->paymethod_id,
            'amount' => $this->amount,
            'op_number' => $this->op_number,
            'date_time' => $this->date_time,
            'description' => $this->description,
            'status' => $this->status
        ];
    }
}
