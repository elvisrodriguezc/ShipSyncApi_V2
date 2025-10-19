<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'label' => strtoupper(number_format($this->stock, 0) . " " . $this->name),
            'value' => (int)$this->id,
            'company_id' => $this->company_id,
            // 'company' => $this->company->name,
            'category_id' => $this->category_id,

            // 'category' => CategoryResource::make($this->category),
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name,
            ],
            'name' => $this->name,
            'description' => $this->description,
            'stockdependency_id' => $this->stockdependency_id,
            // 'image' => $this->image,
            'unit_id' => $this->unit_id,
            // 'unit' => UnitResource::make($this->unit),
            'price' => (float) $this->price,
            'stock' => (float)$this->stock,
            'status' => $this->status,
        ];
    }
}
