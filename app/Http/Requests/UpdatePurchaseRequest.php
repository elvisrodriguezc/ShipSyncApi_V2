<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = auth()->user()?->company_id;
        $purchaseParam = $this->route('purchase');
        $purchaseId = is_object($purchaseParam) ? $purchaseParam->id : $purchaseParam;

        return [
            'warehouse_id' => 'sometimes|exists:warehouses,id',
            'entity_id' => 'sometimes|exists:entities,id',
            'tipo_comprobante' => 'sometimes|string|max:20',
            'numero_comprobante' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('purchases', 'numero_comprobante')
                    ->where(function ($query) use ($companyId, $purchaseId) {
                        $entityId = $this->input('entity_id');
                        $tipoComprobante = $this->input('tipo_comprobante');

                        if (!$entityId || !$tipoComprobante) {
                            $purchase = \App\Models\Purchase::find($purchaseId);
                            $entityId = $entityId ?: $purchase?->entity_id;
                            $tipoComprobante = $tipoComprobante ?: $purchase?->tipo_comprobante;
                        }

                        return $query->where('company_id', $companyId)
                            ->where('entity_id', $entityId)
                            ->where('tipo_comprobante', $tipoComprobante)
                            ->whereNull('deleted_at');
                    })
                    ->ignore($purchaseId),
            ],
            'fecha_emision' => 'sometimes|date',
            'fecha_ingreso' => 'sometimes|date',
            'peso_bruto' => 'nullable|numeric|min:0',
            'status' => 'sometimes|integer',
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
            'numero_comprobante.unique' => 'El número de comprobante ya ha sido registrado para este proveedor y tipo de comprobante.',
        ];
    }
}
