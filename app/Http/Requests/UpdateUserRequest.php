<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'company_id' => 'nullable|integer',
            'headquarter_id' => 'nullable|integer',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|max:50',
            'role_id' => 'required|integer',
            'document_id' => 'required|integer',
            'document_number' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|max:50',
            'license' => 'nullable|string|max:50',
            'licencecategory' => 'nullable|string|max:50',
            'isAF' => 'sometimes|boolean',
            'isAFP' => 'sometimes|boolean',
            'payrollafp_id' => 'nullable|integer',
            'salary' => 'sometimes|numeric',
            'additionalpay' => 'sometimes|numeric',
            'status' => 'required|integer',
        ];
    }
}
