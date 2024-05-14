<?php

namespace App\Http\Resources\V1;

use Hamcrest\Type\IsBoolean;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollUserResource extends JsonResource
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
            'payroll_id' => $this->payroll_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'cargo' => $this->user->cargo,
                'email' => $this->user->email,
                'documento' => $this->user->documento,
                'salary' => $this->user->salary,
                'additionalpay' => $this->user->additionalpay,
            ],
            'base' => $this->base,
            'afamiliar' => $this->user->isAF ? 75 : 0,
            'additional' => $this->aditional,
            'services' => $this->services,
            'afp' => [
                'id' => $this->payrollafp->id,
                'afp' => $this->payrollafp->name,
                'aporte' => $this->payrollafp->aporte,
                'comision' => $this->payrollafp->comision,
                'prima' => $this->payrollafp->prima,
            ],
            'totalremuneracion' => $this->totalremuneracion,
            'totalaporteempleador' => $this->totalaporteempleador,
        ];
    }
}
