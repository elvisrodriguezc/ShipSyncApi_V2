<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseitemRequest extends FormRequest
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
            'purchase_id' => 'required',
            'product_id' => 'required',
            'unity_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'discount' => 'sometimes',
            'discount_percent' => 'sometimes',
            'status' => 'sometimes'
        ];
    }
}
