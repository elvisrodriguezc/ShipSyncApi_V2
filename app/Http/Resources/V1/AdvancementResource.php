<?php

namespace App\Http\Resources\V1;

use App\Models\Advancement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvancementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'company_id' => $this->company_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'role' => $this->user->role,
            ],
            'typevalue' => [
                'id' => $this->typevalue->id,
                'name' => $this->typevalue->name,
            ],
            'typevalue_id' =>  $this->typevalue_id,
            'servicedetail_id' => $this->servicedetail_id,
            'detail' => $this->detail,
            'document' => $this->document,
            'amount' => $this->amount,
            'installments' => $this->installments,
            'manager_id' => $this->manager_id,
            'administrativo' => [
                'id' => $this->manager->id,
                'name' => $this->manager->name,
                'user' => $this->manager->user,
                'role' => $this->manager->role,
            ],
            'items' => AdvancementdetResource::collection($this->advancementdet),
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d h:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d h:i:s')
        ];
    }
}
