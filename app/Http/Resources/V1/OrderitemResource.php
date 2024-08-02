<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class OrderitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imagePath = $this->tariffitem->product->image;
        $imageUrl = $imagePath ? URL::to('/') . env('APP_IMAGE_PATH') . '/' . $imagePath : null;
        return [
            'id' => (int)$this->id,
            'order_id' => $this->order_id,
            'image' => $imageUrl,
            'title' => $this->tariffitem->product->name,
            'model' => $this->tariffitem->product->model,
            'detail' => $this->tariffitem->product->detail,
            'category' => $this->tariffitem->product->category->text,
            'description' => $this->description,
            'currency' => $this->tariffitem->product->currency->symbol,
            'tariffitem_id' => $this->tariffitem_id,
            'tariffitem' => new TariffitemResource($this->tariffitem),
            'warehouse_id' => $this->tariffitem->warehouse_id,
            'product_serie_id' => $this->product_serie_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_percent' => $this->discount_percent,
            'splitfrom' => $this->splitfrom,
            'status' => $this->status,
            'status_comment' => $this->status_comment,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
