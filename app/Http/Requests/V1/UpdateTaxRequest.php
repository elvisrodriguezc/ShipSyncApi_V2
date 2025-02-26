<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxRequest extends FormRequest
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
            'percentage_based' => 'required|boolean',
            'sunat_code' => 'required|string',
            'sunat_namecode' => 'required|string',
            'sunat_operationcode' => 'required|integer',
            'name' => 'required|string',
            'rate' => 'required|numeric',
            'value' => 'required|numeric',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|boolean',
        ];
    }
}
