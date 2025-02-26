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
            'label' => $this->name . ' ' . $this->barcode,
            'accesoryamount' => $this->getAccesoryAmount(),
            'type' => strtolower($this->category->name),
            'company_id' => $this->company_id,
            'name' => $this->name . ' ' . $this->barcode,
            'purchaseprice' => (float) $this->getTotalCost(),
            'detail' => $this->detail,
            'barcode' => $this->barcode,
            'category' => [
                'id' => $this->category->id,
                'type' => strtolower($this->category->name),
                'company_id' => $this->category->company_id,
                'parent_id' => $this->category->parent_id,
                'name' => $this->category->name,
                'icon' => $this->category->icons->prefix . ' fa-' . $this->category->icons->name,
                'description' => $this->category->description,
                'price_rate' => $this->category->price_rate,
            ],
            'unity_id' => $this->unity_id,
            'unity_valor' => $this->unity->value,
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
            'brand' => $this->brand_id ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name
            ] : null,
            'taxes' => $this->producttaxes ? ProducttaxResource::collection($this->producttaxes) : null,
            'unspsc_id' => $this->unspsc_id,
            'content' => $this->content,
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
            'accesories' => $this->accesories ? ProductaccesoryResource::collection($this->accesories) : null,
            'status' => $this->status,
        ];
    }
    private function getAccesoryAmount(): float
    {
        $accesoryamount = 0;
        if ($this->accesories && $this->accesories->isNotEmpty()) {
            $this->accesories->each(function ($accesory) use (&$accesoryamount) {
                $accesoryamount += $accesory->price;
            });
        }
        return $accesoryamount;
    }
    private function getTaxAmount(): float
    {
        $taxamount = 0;
        if ($this->producttaxes && $this->producttaxes->isNotEmpty()) {
            $this->producttaxes->each(function ($tax) use (&$taxamount) {
                if ($tax->tax->percentage_based) {
                    $taxamount += ($this->price + $this->getAccesoryAmount()) * ($tax->rate / 100);
                } else {
                    $taxamount += $tax->value;
                }
            });
        }
        return $taxamount;
    }
    public function getTotalCost(): float
    {
        $totalCost = 0;
        if ($this->price) {
            $totalCost = $this->price + $this->getAccesoryAmount() + $this->getTaxAmount();
        }
        return $totalCost;
    }
}
