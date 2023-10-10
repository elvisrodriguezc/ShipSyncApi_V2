<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "company_id" => "sometimes",
            "category_id" => "sometimes",
            "unity_id" => "sometimes",
            "brand_id" => "sometimes",
            "clasificacion_sunat_id" => "sometimes",
            "currency_id" => "sometimes",
            "name" => "sometimes|max:255",
            "model" => "sometimes",
            "url" => "sometimes",
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:300|dimensions:min_width=200,min_height=200',
            "set_mode" => "sometimes",
            "detail" => "sometimes",
            "minimal" => "sometimes",
            "price" => "sometimes",
            "taxmode_id" => "sometimes",
            "status" => "sometimes"
        ];
    }
}
