<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TariffitemResource extends JsonResource
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
            // 'tariff'=>new TariffResource( $this->tariff),
            'tariff_id' => $this->tariff_id,
            'warehouse' => [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
            ],
            // 'store'=>new StoreResource( $this->store),
            'title' => $this->product->name,
            'text' => $this->product->category->text,
            'type' => strtolower($this->product->category->text),
            'icon' => strtolower($this->product->category->icon),
            'detail' => $this->product->detail,
            'producto' => new ProductResource($this->product),
            'image' => $this->product->image,
            'hide' => false,
            'currency' => $this->product->currency->symbol,
            'price' => (float)$this->price,
            'quantity' => 1,
            'options' => [
                'size' =>  [
                    [
                        'text' => 'small',
                        'price' => 5.00,
                    ], [
                        'text' => 'medum',
                        'price' => 10.00,
                    ],
                ],
                'addon' => [
                    [
                        'text' => "Docker",
                        'price' => 0,
                    ],
                ],
            ],
            'available' => $this->status ? true : false,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
