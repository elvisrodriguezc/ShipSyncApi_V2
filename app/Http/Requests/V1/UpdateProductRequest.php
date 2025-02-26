<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
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
            "company_id" => "sometimes",
            "name" => "required|max:255",
            "detail" => "sometimes",
            "barcode" => "sometimes",
            "category_id" => "sometimes",
            "unity_id" => "sometimes",
            "model" => "sometimes",
            "url" => "sometimes",
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=200,min_height=200',
            "set_mode" => "sometimes",
            "currency_id" => "sometimes",
            "price" => "sometimes",
            "minimal" => "sometimes",
            "brand_id" => "sometimes",
            "unspsc_id" => "sometimes",
            'content' => "sometimes",
            'weight' => "sometimes",
            'height' => "sometimes",
            'length' => "sometimes",
            'width' => "sometimes",
            'condition_id' => "sometimes",
            'warrantytype_id' => "sometimes",
            'warrantymonths' => "sometimes",
            'depreciationmonths' => "sometimes",
            "status" => "sometimes",
        ];
    }
}
