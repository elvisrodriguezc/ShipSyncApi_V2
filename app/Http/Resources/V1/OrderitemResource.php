<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderitemResource extends JsonResource
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
            'order_id' => $this->order_id,
            'tariffitem_id' => $this->tariffitem_id,
            'image' => $this->tariffitem->product->image,
            'title' => $this->tariffitem->product->name,
            'currency' => $this->tariffitem->product->currency->symbol,
            'tariff_item' => new TariffitemResource($this->tariffitem),
            'warehouse_id' => $this->tariffitem->warehouse_id,
            'product_serie_id' => $this->product_serie_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_percent' => $this->discount_percent,
            'description' => $this->description,
            'splitfrom' => $this->splitfrom,
            'status' => $this->status,
            'status_comment' => $this->status_comment,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
