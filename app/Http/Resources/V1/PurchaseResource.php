<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'company' => $this->company->name,
            'warehouse' => [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
                'office' => $this->warehouse->office->name,
                'address' => $this->warehouse->office->address,
            ],
            'user_id' => $this->user_id,
            'serie' => $this->numerator->serie,
            'number' => $this->number,
            'entity' => new EntityResource($this->entity),
            'receipttype' => [
                'id' => $this->receipttype_id,
                'name' => $this->receipttype->name,
                'abbrev' => $this->receipttype->abbrev,
            ],
            'document_serial' => $this->document_serial,
            'document_number' => $this->document_number,
            'guide_number' => $this->guide_number,
            'date' => $this->date,
            'credit' => (bool)$this->credit,
            'duedate' => $this->duedate,
            'items' => new PurchaseitemCollection($this->purchaseitems),
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d h:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d h:i:s')
        ];
    }
}
