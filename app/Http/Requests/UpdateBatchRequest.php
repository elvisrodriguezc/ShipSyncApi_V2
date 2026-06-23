<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_lote_proveedor' => 'sometimes|string|max:30',
            'in_date' => 'sometimes|date',
            'fecha_fabricacion' => 'nullable|date',
            'fecha_vencimiento' => 'sometimes|date|after:in_date',
            'estado' => 'nullable|integer|min:1|max:4',
        ];
    }
}
