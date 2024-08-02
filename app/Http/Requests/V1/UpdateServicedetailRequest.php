<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicedetailRequest extends FormRequest
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
            'initkm' => 'sometimes|required',
            'finalkm' => 'sometimes',
            'initkmGPS' => 'sometimes',
            'finalkmGPS' => 'sometimes',
            'status' => 'sometimes',
            'status' => 'sometimes',
        ];
    }
}
