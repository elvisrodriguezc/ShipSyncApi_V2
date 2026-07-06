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
            'id_producto' => 'required|exists:products,id',
            'numero_lote_proveedor' => 'nullable|string|max:30',
            'in_date' => 'required|date',
            'fecha_fabricacion' => 'nullable|date',
            'fecha_vencimiento' => 'required|date|after:in_date',
            'estado' => 'nullable|integer|min:1|max:4',
            'purchase_id' => 'nullable|integer|exists:purchases,id',
            'stock_inicial' => 'required|numeric|min:0',
            'stock_actual' => 'nullable|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'purchase_id' => 'documento de compra',
            'stock_inicial' => 'stock inicial',
            'stock_actual' => 'stock actual',
        ];
    }
}
