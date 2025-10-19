<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderformitemRequest extends FormRequest
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
            'orderline' => ['sometimes', 'string', 'max:255'],
            'quantity' => ['sometimes', 'numeric', 'min:0'],
            'unit_price' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'integer']
        ];
    }
}
