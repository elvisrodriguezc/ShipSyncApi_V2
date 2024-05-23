<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'company_id' => $this->company_id,
            'parent_id' => $this->parent_id,
            'text' => $this->text,
            'type' => strtolower($this->text),
            'icon' => $this->icons->prefix . ' fa-' . $this->icons->name,
            'description' => $this->description,
            'price_rate' => $this->price_rate,
            'status' => $this->status
            // 'created_at' => $this->created_at->format('Y-m-d h:i:s'),
            // 'updated_at' => $this->updated_at->format('Y-m-d h:i:s')
        ];
    }
}
