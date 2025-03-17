<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
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
            'headquarter_id' => 'required|integer',
            'warehouse_id' => 'nullable|integer',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'mode' => 'nullable|string|max:10',
        ];
    }
}
