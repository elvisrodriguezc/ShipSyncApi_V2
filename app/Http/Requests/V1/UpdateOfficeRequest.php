<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficeRequest extends FormRequest
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
            'name' => 'sometimes|required|unique:offices,name|min:4',
            'ubigeodistrito_id' => 'sometimes|required',
            'address' => 'sometimes|required',
            'phone',
            'email' => 'sometimes|required|email',
            'status',
        ];
    }
}
