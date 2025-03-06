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
            'value' => $this->id,
            'label' => $this->first_name . ' ' . $this->last_name,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'headquarter_id' => $this->headquarter_id,
            'headquarter' => $this->headquarter,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'role' => $this->role,
            'document_id' => $this->document_id,
            'document' => $this->document,
            'document_number' => $this->document_number,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'license' => $this->license,
            'licencecategory' => $this->licencecategory,
            'isAF' => $this->isAF,
            'isAFP' => $this->isAFP,
            'payrollafp_id' => $this->payrollafp_id,
            'payrollafp' => $this->payrollafp,
            'salary' => $this->salary,
            'additionalpay' => $this->additionalpay,
            'document' => $this->document,
            'status' => (int) $this->status,
        ];
    }
}
