<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTariffitemRequest extends FormRequest
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
            'tariff_id' => 'required',
            'warehouse_id' => 'required',
            'product_id' => 'required',
            'currency_id' => 'required',
            'price' => 'required',
            'status' => 'sometimes',
            'product_id' => 'unique:tariffitems,product_id,NULL,id,tariff_id,' . $this->tariff_id,
        ];
    }
}
