<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderformRequest extends FormRequest
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
            'company_id' => ['sometimes', 'integer'],
            'headquarter_id' => ['sometimes', 'integer'],
            'warehouse_id' => ['sometimes', 'integer'],
            'user_id' => ['sometimes', 'integer'],
            'entity_id' => ['sometimes', 'integer'],
            'typevalue_id' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'integer'],
        ];
    }
}
