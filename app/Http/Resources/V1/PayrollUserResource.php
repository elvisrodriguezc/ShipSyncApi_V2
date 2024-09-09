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
                'salary' => (float)$this->user->salary,
                'additionalpay' => (float)$this->user->additionalpay,
            ],
            'base' => (float)$this->base,
            'afamiliar' => (float)$this->user->isAF ? 75 : 0,
            'additional' => (float)$this->aditional,
            'services' => (float)$this->services,
            'afp' => [
                'id' => $this->payrollafp->id,
                'afp' => $this->payrollafp->name,
                'aporte' => (float)$this->payrollafp->aporte,
                'comision' => (float)$this->payrollafp->comision,
                'prima' => (float)$this->payrollafp->prima,
            ],
            'totalremuneracion' => (float)$this->totalremuneracion,
            'totalaporteempleador' => (float)$this->totalaporteempleador,
        ];
    }
}
