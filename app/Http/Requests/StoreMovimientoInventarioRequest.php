<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoInventarioRequest extends FormRequest
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
            'tipo_movimiento' => 'required|integer|min:1|max:5',
            'cantidad' => 'required|numeric',
            'saldo' => 'required|numeric',
            'fecha_movimiento' => 'sometimes|date',
            'documento_referencia' => 'nullable|string|max:100',
            'usuario_id' => 'required|integer|exists:users,id',
            'company_id' => 'required|integer|exists:companies,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->validated();
            if (empty($data['id_lote']) && empty($data['id_producto'])) {
                $validator->errors()->add('id_lote', 'Debe proporcionar id_lote o id_producto');
            }
        });
    }
}
