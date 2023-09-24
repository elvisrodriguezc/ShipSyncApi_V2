<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCashierdetailRequest extends FormRequest
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
            'paymethod_id' => 'sometimes',
            'amount' => 'sometimes',
            'op_number' => 'sometimes',
            'date_time' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ];
    }
}
