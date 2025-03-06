<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramationRequest extends FormRequest
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
            // 'company_id' => 'required',
            // 'numerator_id' => 'required',
            // 'user_id' => 'required',
            // 'number' => 'required',
            'customer_id' => 'required',
            'date' => 'required',
            'note' => 'optional',
        ];
    }
}
