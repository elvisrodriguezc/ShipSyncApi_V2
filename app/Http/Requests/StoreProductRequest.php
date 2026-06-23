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
            'vida_util' => 'nullable|integer|min:0|max:255',
            'requiere_lote' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
            'unit_id' => 'required|integer',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ];
    }
}
