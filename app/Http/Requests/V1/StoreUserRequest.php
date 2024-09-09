<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'lastname' => 'required',
            'company_id' => 'sometimes',
            'warehouse_id' => 'sometimes',
            'user' => 'required',
            'email' => 'required',
            'typevalue_id' => 'sometimes',
            'documento' => 'sometimes',
            'password' => 'sometimes',
            'role' => 'required',
            'licence' => 'sometimes',
            'licencecategory' => 'sometimes',
            'isAF' => 'sometimes',
            'isAFP' => 'sometimes',
            'payrollafp_id' => 'sometimes',
            'salary' => 'sometimes',
            'additionalpay' => 'sometimes',
            'status' => 'sometimes'
        ];
    }
}
