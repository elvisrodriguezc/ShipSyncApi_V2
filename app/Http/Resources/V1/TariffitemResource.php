<?php

namespace App\Http\Resources\V1;

use App\Models\Productaccesory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\V1\ProductResource;

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
        $productCurrent = new ProductResource($this->product);

        // Calcular la suma de los precios de los accesorios multiplicados por la cantidad
        return [
            'id' => (int)$this->id,
            // 'tariff'=>new TariffResource( $this->tariff),
            'tariff_id' => $this->tariff_id,
            'category_rate' => (int)$this->product?->category->price_rate,
            'tariff_rate' => (int)$this->tariff->rate,
            'tariff_currency' => (int)$this->tariff->currency->id,
            'price_mode' => $this->price == 0 ? 'A' : 'M',
            'cost' => (($productCurrent->getTotalCost()) * ($productCurrent->currency->rate)),
            'price' => (float)$this->price > 0
                ? (float)$this->price
                : (($productCurrent->getTotalCost()) * (($productCurrent->category->price_rate + $this->tariff->rate) / 100 + 1) * ($productCurrent->currency->rate / $this->tariff->currency->rate)),
            'total_rate' => ($this->product?->category->price_rate + $this->tariff->rate),
            'warehouse_id' => $this->warehouse_id,
            'warehouse' => [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
            ],
            // 'store'=>new StoreResource( $this->store),
            'title' => $this->product?->name,
            'text' => $this->product?->category->name,
            'type' => strtolower($this->product?->category->name),
            'icon' => strtolower($this->product?->category->icon),
            'product' => $productCurrent,
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
