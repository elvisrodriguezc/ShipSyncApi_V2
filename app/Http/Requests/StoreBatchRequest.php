<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_lote_proveedor' => 'nullable|string|max:30',
            'in_date' => 'required|date',
            'fecha_fabricacion' => 'nullable|date',
            'fecha_vencimiento' => 'required|date|after:in_date',
            'estado' => 'nullable|integer|min:1|max:4',
        ];
    }
}
