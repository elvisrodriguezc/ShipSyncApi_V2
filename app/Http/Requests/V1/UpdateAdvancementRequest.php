<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdvancementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|sometimes',
            'typevalue_id' => 'required|sometimes',
            'servicedetail_id' => 'nullable',
            'detail' => 'required|sometimes',
            'document' => 'nullable',
            'amount' => 'required|sometimes',
            'installments' => 'required|sometimes',
            'status' => 'nullable',
        ];
    }
}
