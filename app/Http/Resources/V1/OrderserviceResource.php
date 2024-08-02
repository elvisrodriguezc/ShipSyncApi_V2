<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderserviceResource extends JsonResource
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
            "order_id" => $this->order_id,
            "order" => [
                "id" => $this->order->id,
                "status" => $this->order->status,
                "number" => $this->order->number,
                "office_id" => $this->order->office->id,
                "user_id" => $this->order->user->id,
                "user" => $this->order->user->user,
                "table_id" => $this->order->table_id,
                "entity_id" => $this->order->entity->id,
                "entity" => $this->order->entity->company_name,
            ],
            "warehouse_id" => $this->warehouse_id,
            "warehouse" => [
                "id" => $this->warehouse->id,
                "name" => $this->warehouse->name,
                "office_id" => $this->warehouse->office->id,
            ],
            "updateby_id" => $this->updateby_id,
            "updateby" => [
                "id" => $this->updateby->id,
                "user" => $this->updateby->user,
            ],
            "starting" => $this->starting,
            "finishing" => $this->finishing,
            "note" => $this->note,
            'items' => new OrderserviceitemCollection($this->orderserviceitem),
            "status" => $this->status,
            "created_at" => $this->created_at?->format('Y-m-d H:i:s'),
            "updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
