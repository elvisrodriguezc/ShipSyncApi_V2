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
            'date' => $this->date,
            'company_id' => $this->compphpany_id,
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
            'contact' => ContactResource::make($this->contact),
            'orderformitems' => OrderformitemResource::collection($this->orderformitems),
            'order_line' => $this->order_line,
            'observation' => $this->observation,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'finished_at' => $this->finished_at,
            // 'finished_at' => $this->finished_at?->format('Y-m-d H:i:s'),

        ];
    }
}
