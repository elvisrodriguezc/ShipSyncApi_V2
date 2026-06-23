<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'elvis' => 'elvis',
            'value' => $this->id,
            'label' => $this->first_name . ' ' . $this->last_name,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'headquarter_id' => $this->headquarter_id,
            'headquarter' => $this->headquarter,
            'warehouse_id' => $this->warehouse_id,
            'warehouse' => $this->warehouse,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'role_id' => $this->role_id,
            'role' => RoleResource::make($this->role),
            'roles' => RoleResource::collection($this->roles),
            'document_id' => $this->document_id,
            'document' => $this->document,
            'document_number' => $this->document_number,
            'contact_id' => $this->contact_id,
            'contact' => ContactResource::make($this->contact),
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'license' => $this->license,
            'licencecategory' => $this->licencecategory,
            'salary' => $this->salary,
            'additionalpay' => $this->additionalpay,
            'status' => (int) $this->status,
        ];
    }
}
