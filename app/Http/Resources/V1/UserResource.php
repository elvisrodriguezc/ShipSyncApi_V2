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
            'role' => $this->role,
            'user' => $this->user,
            'names' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'doctipo' =>  $this->typevalue->name,
            'doctipocod' =>  $this->typevalue->value,
            'documento' => $this->documento,
            'licence' => $this->licence,
            'licencecategory' => $this->licencecategory,
            'label' => $this->name,
            'value' => $this->id,
            'salario' =>  $this->salary,
            'adicional' =>  $this->additionalpay,
            'isAF' =>  $this->isAF,
            'isAFP' =>  $this->isAFP,
            'afp' => $this->payrollafp->name,
            'status' => $this->status
        ];
    }
}
