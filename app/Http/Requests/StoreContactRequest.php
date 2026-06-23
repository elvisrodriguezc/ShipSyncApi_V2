<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'bussiness_name' => 'nullable|string|max:50',
            'bussiness_tipe_id' => 'nullable|exists:bussiness_tipes,id',
            'email' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'status' => 'sometimes',
        ];
    }
}
