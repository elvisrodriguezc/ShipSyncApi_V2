<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "company_id",
            "category_id" => "required",
            "unity_id" => "required",
            "brand_id" => "required",
            "taxmode_id" => "required",
            "clasificacion_sunat_id",
            "currency_id" => "required",
            "name" => "required|unique:products,name|max:255",
            "model",
            "url" => "required",
            "image" => "required",
            "set_mode" => "required",
            "detail" => "required",
            "minimal" => "required",
            "price" => "required",
            "status",
        ];
    }
}
