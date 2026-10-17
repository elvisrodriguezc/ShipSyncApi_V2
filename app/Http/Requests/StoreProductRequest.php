<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('requiere_lote')) {
            $this->merge([
                'requiere_lote' => filter_var($this->requiere_lote, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:15',
            'description' => 'nullable|string|max:1000',
            'peso' => 'nullable|integer|min:0',
            'vida_util' => 'nullable|integer|min:0|max:65535',
            'requiere_lote' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
            'unit_id' => 'required|integer',
            'price' => 'nullable|numeric|min:0',
            'stockdependency_id' => 'nullable|exists:products,id',
        ];
    }
}
