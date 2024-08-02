<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicedetspentRequest extends FormRequest
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
            'servicedetail_id' => 'required',
            'ruc' => 'required',
            'serie' => 'required',
            'number' => 'required',
            'amount' => 'required',
            'detail' => 'required',
            'typecpe_id' => 'required',
            'status' => 'sometimes',
        ];
    }
}
