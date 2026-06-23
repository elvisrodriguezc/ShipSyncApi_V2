<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'entity_id' => 'required|exists:entities,id',
            'tipo_comprobante' => 'required|string|max:20',
            'numero_comprobante' => 'required|string|max:50',
            'fecha_emision' => 'required|date',
            'fecha_ingreso' => 'required|date',
            'peso_bruto' => 'nullable|numeric|min:0',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.cantidad' => 'required|numeric|min:0.01',
            'details.*.id_lote' => 'nullable|integer|exists:batches,id_lote',
            'details.*.costo_unitario' => 'nullable|numeric|min:0',
        ];
    }
}
