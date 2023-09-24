<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'entity_id' => "sometimes",
            'cashier_id' => "sometimes",
            'currency_id' => "sometimes",
            'table_id' => "sometimes",
            'tariff_id' => "sometimes",
            'number' => "sometimes",
            'pax' => "sometimes",
            'discount' => "sometimes",
            'total' => "sometimes",
            'status' => "sometimes|required",
        ];
    }
}
