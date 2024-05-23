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
            'name' => $this->name,
            'email' => $this->email,
            'doctipo' =>  $this->typevalue->name,
            'documento' => $this->documento,
            'label' => $this->name,
            'value' => $this->id,
            'salario' =>  $this->salary,
            'adicional' =>  $this->additionalpay,
            'afp' => $this->payrollafp->name
        ];
    }
}
