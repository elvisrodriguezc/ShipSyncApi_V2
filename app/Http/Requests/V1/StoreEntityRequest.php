<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
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
            'company_id' => "sometines",
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'company_name' => "required",
            'idform_id' => 'sometimes',
            'idform_number' => 'required',
            'phone' => "sometimes",
            'email' => "sometimes",
            'ubigeodistrito_id' => "sometimes",
            'address' => 'sometimes',
            'remark' => "sometimes",
        ];
    }
}
