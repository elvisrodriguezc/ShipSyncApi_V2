<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'unique:companies,name|required|string|max:255',
            'ruc' => 'unique:companies,ruc|required|string|max:11',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'logo' => 'required',
            'web' => 'required',
            'description' => 'required'
        ];
    }
}
