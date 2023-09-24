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
            "company_id" => "sometimes|required",
            "category_id" => "sometimes|required",
            "unity_id" => "sometimes|required",
            "brand_id" => "sometimes|required",
            "clasificacion_sunat_id" => "sometimes|required",
            "currency_id" => "sometimes|required",
            "name" => "sometimes|required|unique:products,name|max:255",
            "model" => "sometimes",
            "url" => "sometimes",
            "image" => "sometimes",
            "set_mode" => "sometimes|required",
            "detail" => "sometimes|required",
            "minimal" => "sometimes|required",
            "price" => "sometimes|required",
            "taxmode_id" => "sometimes|required",
            "status" => "sometimes|required"
        ];
    }
}
