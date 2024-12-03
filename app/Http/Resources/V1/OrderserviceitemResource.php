<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Type\Integer;

class OrderserviceitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "orderservice_id" => $this->orderservice_id,
            "orderitem_id" => $this->orderitem->id,
            "orderitem" => new OrderitemResource($this->orderitem), // Corregimos aquí
            "updateby_id" => $this->updateby_id,
            "updateby" => [
                "user" => $this->updateby->user,
            ],
            "note" => $this->note,
            "status" => (int)$this->status,
            "created_at" => $this->created_at?->format('Y-m-d H:i:s'), // Corregimos el formato
            "updated_at" => $this->updated_at?->format('Y-m-d H:i:s'), // Corregimos el formato
        ];
    }
}
