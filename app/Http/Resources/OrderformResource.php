<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderformResource extends JsonResource
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
            'company_id' => $this->company_id,
            'headquarter_id' => $this->headquarter_id,
            'warehouse_id' => $this->warehouse_id,
            'user_id' => $this->user_id,
            'entity_id' => $this->entity_id,
            'typevalue_id' => $this->typevalue_id,
            'status' => $this->status,
            'company' => $this->company->name,
            // 'headquarter' => HeadquarterResource::make($this->headquarter),
            'headquarter' => $this->headquarter->name,
            'warehouse' => $this->warehouse->name,
            'user' => [
                'id' => $this->user->id,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'username' => $this->user->username,
            ],
            'entity' => [
                'id' => $this->entity->id,
                'razon_social' => $this->entity->razon_social,
                'ruc' => $this->entity->ruc,
            ],
            'typevalue' => [
                'id' => $this->typevalue->id,
                'name' => $this->typevalue->name,
                'description' => $this->typevalue->description,
                'abbreviation' => $this->typevalue->abbreviation,
            ],
            'items' => OrderformitemResource::collection($this->orderformitems),
            'observation' => $this->observation,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'finished_at' => $this->finished_at,
            // 'finished_at' => $this->finished_at?->format('Y-m-d H:i:s'),

        ];
    }
}
