<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class TariffitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imagePath = $this->product?->image;
        $imageUrl = $imagePath ? URL::to('/') . env('APP_IMAGE_PATH') . '/' . $imagePath : "";
        return [
            'id' => (int)$this->id,
            // 'tariff'=>new TariffResource( $this->tariff),
            'tariff_id' => $this->tariff_id,
            'category_rate' => (int)$this->product?->category->price_rate,
            'tariff_rate' => (int)$this->tariff->rate,
            'tariff_currency' => (int)$this->tariff->currency->id,
            'product_price' => (float)$this->product?->price,
            'price_mode' => (float)$this->price == 0 ? 'A' : 'M',
            'price' => (float)$this->price > 0
                ? (float)$this->price
                : ($this->product?->price * 1.18) * (($this->product?->category->price_rate + $this->tariff->rate) / 100 + 1) * ($this->product?->currency->rate / $this->tariff->currency->rate),
            'total_rate' => ($this->product?->category->price_rate + $this->tariff->rate),
            'warehouse_id' => $this->warehouse_id,
            'warehouse' => [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
            ],
            // 'store'=>new StoreResource( $this->store),
            'title' => $this->product?->name,
            'text' => $this->product?->category->text,
            'type' => strtolower($this->product?->category->text),
            'icon' => strtolower($this->product?->category->icon),
            'detail' => $this->product?->detail,
            'producto' => new ProductResource($this->product),
            'image' =>  $imageUrl,
            'hide' => false,
            'currency_id' => $this->currency_id,
            'currency' => $this->tariff->currency->symbol,
            // 'price' => (float)$this->price,
            'quantity' => 1,
            'options' => [
                'size' =>  [
                    [
                        'text' => 'standart',
                        'price' => 0.00,
                    ],
                    // [
                    //     'text' => 'small',
                    //     'price' => 5.00,
                    // ],
                    // [
                    //     'text' => 'medum',
                    //     'price' => 10.00,
                    // ],
                ],
                'addon' => [
                    // [
                    //     'text' => "Docker",
                    //     'price' => 0,
                    // ],
                ],
            ],
            'available' => $this->status ? true : false,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
