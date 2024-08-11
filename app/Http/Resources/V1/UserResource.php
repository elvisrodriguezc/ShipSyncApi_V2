<?php

namespace App\Http\Resources\V1;

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
            'label' => $this->name . ' ' . $this->lastname,
            'value' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'company_id' => $this->company_id,
            'company' => $this->company->name,
            'company_logo' => $this->company->logo,
            'warehouse_id' => $this->warehouse_id,
            'user' => $this->user,
            'role' => $this->role,
            'email' => $this->email,
            'doctipo' =>  $this->typevalue->name,
            'doctipocod' =>  $this->typevalue->value,
            'documento' => $this->documento,
            'licence' => $this->licence,
            'licencecategory' => $this->licencecategory,
            'isAF' =>  $this->isAF,
            'isAFP' =>  $this->isAFP,
            'payrollafp_id' =>  $this->payrollafp_id,
            'afp' => $this->payrollafp->name,
            'salario' =>  $this->salary,
            'adicionalpay' =>  $this->additionalpay,
            'status' => $this->status
        ];
    }
}
