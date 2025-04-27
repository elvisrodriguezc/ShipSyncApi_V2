<?php

namespace App\Http\Resources;

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
            'label' => strtoupper($this->stock . " " . $this->name),
            'value' => (int)$this->id,
            'company_id' => $this->company_id,
            'company' => $this->company->name,
            'category_id' => $this->category_id,
            'category' => CategoryResource::make($this->category),
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'unit_id' => $this->unit_id,
            'unit' => UnitResource::make($this->unit),
            'price' => (float) $this->price,
            'stock' => (float)$this->stock,
            'status' => $this->status,
        ];
    }
}
