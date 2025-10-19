<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderformRequest extends FormRequest
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
            'date' => ['nullable', 'date'],
            'headquarter_id' => ['nullable', 'integer'],
            'warehouse_id' => ['nullable', 'integer'],
            'entity_id' => ['nullable', 'integer'],
            'contact_id' => ['required', 'integer'],
            'typevalue_id' => ['nullable', 'integer'],
            'order_line' => ['nullable', 'string'],
            'observation' => ['nullable', 'string'],
            'orderItems' => ['required', 'array'],
            'orderItems.*.product_id' => ['required', 'integer'],
            'orderItems.*.quantity' => ['required', 'numeric'],
        ];
    }
}
