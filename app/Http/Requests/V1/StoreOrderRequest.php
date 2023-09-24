<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'entity_id' => 'required',
            'cashier_id' => 'required',
            'currency_id' => 'required',
            'table_id' => 'sometimes|required',
            'tariff_id' => 'required',
            'number' => 'sometimes|required',
            'pax' => 'sometimes|required',
            'discount' => 'sometimes|required',
            'total' => 'sometimes|required',
            'status' => 'required',
        ];
    }
}
