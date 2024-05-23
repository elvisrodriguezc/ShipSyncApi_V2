<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imagePath = $this->image;
        $imageUrl = $imagePath ? URL::to('/') . env('APP_IMAGE_PATH') . '/' . $imagePath : null;
        return [
            'id' => (int) $this->id,
            'value' => $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'label' => $this->name,
            'model' => $this->model,
            'detail' => $this->detail,
            'type' => strtolower($this->category->text),
            'category' => [
                'id' => $this->category->id,
                'type' => strtolower($this->category->text),
                'company_id' => $this->category->company_id,
                'parent_id' => $this->category->parent_id,
                'text' => $this->category->text,
                'icon' => $this->category->icons->prefix . ' fa-' . $this->category->icons->name,
                'description' => $this->category->description,
                'price_rate' => $this->category->price_rate,
            ],
            'unity_id' => $this->unity_id,
            'unity' => [
                "id" => $this->unity->id,
                "name" => $this->unity->name,
                "abbrev" => $this->unity->abbreviation,
            ],
            'brand_id' => $this->brand_id,
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name
            ],
            'currency_id' => $this->currency_id,
            'currency' => [
                "id" => $this->currency->id,
                "name" => $this->currency->name,
                "symbol" => $this->currency->symbol,
            ],
            'taxmode_id' => $this->taxmode_id,
            'taxmode' => [
                "id" => $this->taxmode->id,
                "name" => $this->taxmode->name,
                "code" => $this->taxmode->code,
            ],
            'clasificacion_sunat_id' => $this->clasificacion_sunat_id,
            'url' => $this->url,
            'image' => $imageUrl,
            'set_mode' => $this->set_mode,
            'minimal' => (float)$this->minimal,
            'price' => (float) $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
