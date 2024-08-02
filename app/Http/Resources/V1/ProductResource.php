<?php

namespace App\Http\Resources\V1;

use App\Models\Productvariant;
use App\Models\Warehousestock;
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
            'label' => $this->name,
            'type' => strtolower($this->category->text),
            'company_id' => $this->company_id,
            'name' => $this->name,
            'detail' => $this->detail,
            'barcode' => $this->barcode,
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
            'unity' => new UnityResource($this->unity),
            'model' => $this->model,
            'url' => $this->url,
            'image' => $imageUrl,
            'set_mode' => $this->set_mode,
            'currency_id' => $this->currency_id,
            'currency' => [
                "id" => $this->currency->id,
                "name" => $this->currency->name,
                "symbol" => $this->currency->symbol,
            ],
            'price' => (float) $this->price,
            'minimal' => (float)$this->minimal,
            'brand_id' => $this->brand_id,
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name
            ],
            'taxmode_id' => $this->taxmode_id,
            'taxmode' => [
                "id" => $this->taxmode->id,
                "name" => $this->taxmode->name,
                "code" => (string)$this->taxmode->value,
            ],
            'unspsc_id' => $this->unspsc_id,
            'content' => $this->content,
            'weight' => $this->weight,
            'height' => $this->height,
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'condition' => [
                "name" => $this->condition?->name,
                "abbrev" => $this->condition?->abbrev,
                "id" => $this->condition?->id,
            ],
            'warrantytype' => [
                'id' => $this->warrantytype?->id,
                'name' => $this->warrantytype?->name,
                'abbrev' => $this->warrantytype?->abbrev,
            ],
            'warrantymonths' => $this->warrantymonths,
            'depreciationmonths' => $this->depreciationmonths,
            // 'stock' => new WarehousestockResource($this->warehousestocks),
            'total_stock' => (float)$this->total_stock,
            'variants' => $this->variants ? ProductvariantResource::collection($this->variants) : null,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
