<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = auth()->user()?->company_id;

        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'entity_id' => 'required|exists:entities,id',
            'tipo_comprobante' => 'required|string|max:20',
            'numero_comprobante' => [
                'required',
                'string',
                'max:50',
                Rule::unique('purchases', 'numero_comprobante')
                    ->where(function ($query) use ($companyId) {
                        return $query->where('company_id', $companyId)
                            ->where('entity_id', $this->input('entity_id'))
                            ->where('tipo_comprobante', $this->input('tipo_comprobante'))
                            ->whereNull('deleted_at');
                    }),
            ],
            'fecha_emision' => 'required|date',
            'fecha_ingreso' => 'required|date',
            'peso_bruto' => 'nullable|numeric|min:0',
            'details' => 'nullable|array',
            'details.*.product_id' => 'required_with:details|exists:products,id',
            'details.*.cantidad' => 'required_with:details|numeric|min:0.01',
            'details.*.id_lote' => 'nullable|integer|exists:batches,id_lote',
            'details.*.costo_unitario' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'numero_comprobante.unique' => 'El número de comprobante ' . $this->input('tipo_comprobante') . ' ' . $this->input('numero_comprobante') . ' ya ha sido registrado para este proveedor.',
        ];
    }
}
