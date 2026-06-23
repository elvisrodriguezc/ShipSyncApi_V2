<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'sometimes|exists:warehouses,id',
            'entity_id' => 'sometimes|exists:entities,id',
            'tipo_comprobante' => 'sometimes|string|max:20',
            'numero_comprobante' => 'sometimes|string|max:50',
            'fecha_emision' => 'sometimes|date',
            'fecha_ingreso' => 'sometimes|date',
            'peso_bruto' => 'nullable|numeric|min:0',
            'status' => 'sometimes|integer',
            'details' => 'sometimes|array|min:1',
            'details.*.product_id' => 'required_with:details|exists:products,id',
            'details.*.cantidad' => 'required_with:details|numeric|min:0.01',
            'details.*.id_lote' => 'nullable|integer|exists:batches,id_lote',
            'details.*.costo_unitario' => 'nullable|numeric|min:0',
        ];
    }
}
