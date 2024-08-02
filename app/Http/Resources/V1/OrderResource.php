<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'office_id' => $this->company_id,
            'company' => [
                'id' => $this->office->company->id,
                'name' => $this->office->company->name,
                'ruc' => $this->office->company->ruc,
                'address' => $this->office->company->address,
                'phone' => $this->office->company->phone,
                'email' => $this->office->company->email,
                'logo' => $this->office->company->logo,
                'web' => $this->office->company->web,
                'description' => $this->office->company->description,
                'cta1' => $this->office->company->cta1,
                'cta2' => $this->office->company->cta2,
            ],
            'cashier_id' => $this->cashier_id,
            'cashier' => [
                'id' => $this->cashier->id,
                'status' => $this->cashier->status,
                'created_at' => $this->cashier->created_at->format('Y-m-d H:i:s'),
            ],
            // 'cashier'=>new CashierResource( $this->cashier),
            'user_id' => $this->user_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            // 'user'=>new UserResource( $this->user),
            'entity_id' => $this->entity_id,
            'entity' => [
                'id' => $this->entity->id,
                'first_name' => $this->entity->first_name,
                'last_name' => $this->entity->last_name,
                'company_name' => $this->entity->company_name,
                'idform_id' => $this->entity->idform_id,
                'idform_number' => $this->entity->idform_number,
                'idform_name' => $this->entity->idform->name,
                'address' => $this->entity->address,
                'phone' => $this->entity->phone,
                'email' => $this->entity->email,
                'distrito' => $this->entity->ubigeodistrito->name,
                'provincia' => $this->entity->ubigeodistrito->ubigeoprovincia->name,
                'region' => $this->entity->ubigeodistrito->ubigeoprovincia->ubigeodepartamento->name,
            ],
            // 'customer'=>new CustomerResource( $this->customer),
            'table_id' => $this->table_id,
            'table' => [
                'id' => $this->table->id,
                'name' => $this->table->name,
                'seatcount' => $this->table->seatcount,
                'status' => $this->table->status,
            ],
            // 'table'=>new TableResource( $this->table),
            'items' => new OrderitemCollection($this->orderitem),
            // 'receipts' => new ReceiptCollection($this->receipt),
            'tariff_id' => $this->tariff_id,
            'tariff' => [
                'id' => $this->tariff->id,
                'name' => $this->tariff->name,
                // 'company_id' => $this->tariff->company_id,
                'rate' => $this->tariff->rate,
            ],
            // 'tariff'=>new TariffResource( $this->tariff),
            'number' => $this->number,
            'pax' => $this->pax,
            'discount' => $this->discount,
            'total' => (float)$this->total,
            'currency_id' => $this->currency_id,
            'currency' => $this->currency->symbol,
            'status' => $this->status,
            'created_at1' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at1' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
