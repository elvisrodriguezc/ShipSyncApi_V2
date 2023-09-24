<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTariffitemRequest extends FormRequest
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
            'tariff_id' => 'sometimes|required',
            'warehouse_id' => 'sometimes|required',
            'product_id' => 'sometimes|required',
            'currency_id' => 'sometimes|required',
            'price' => 'sometimes|required',
            'status' => 'sometimes|required',
        ];
    }
}
