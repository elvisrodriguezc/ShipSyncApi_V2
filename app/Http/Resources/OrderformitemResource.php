<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderformitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'orderform_id' => $this->orderform_id,
            'product_id' => $this->product_id,
            'product' => ProductResource::make($this->product),
            'unit_id' => $this->unit_id,
            'unit' => UnitResource::make($this->unit),
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'status' => $this->status,
            'note' => OrderformitemcommentResource::collection($this->orderformitemcomments),
        ];
    }
}
