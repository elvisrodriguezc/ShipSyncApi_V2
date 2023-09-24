<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderitemRequest extends FormRequest
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
            'tariffitem_id' => 'sometimes|required',
            'product_serie_id' => 'sometimes|required',
            'quantity' => 'sometimes|required',
            'price' => 'sometimes|required',
            'discount' => 'sometimes|required',
            'discount_percent' => 'sometimes|required',
            'description' => 'sometimes|required',
            'splitfrom' => 'sometimes|required',
            'status' => 'sometimes|required',
            'status_comment' => 'sometimes|required',
        ];
    }
}
