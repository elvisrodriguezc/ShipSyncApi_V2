<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovimientoInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_lote' => 'nullable|integer|exists:batches,id_lote',
            'id_producto' => 'nullable|integer|exists:products,id',
            'tipo_movimiento' => 'sometimes|integer|min:1|max:5',
            'cantidad' => 'sometimes|numeric',
            'saldo' => 'sometimes|numeric',
            'fecha_movimiento' => 'sometimes|date',
            'documento_referencia' => 'nullable|string|max:100',
            'usuario_id' => 'sometimes|integer|exists:users,id',
            'company_id' => 'sometimes|integer|exists:companies,id',
        ];
    }
}
