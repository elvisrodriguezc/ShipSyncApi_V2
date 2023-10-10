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
            "company_id" => "sometimes",
            "category_id" => "required",
            "unity_id" => "required",
            "brand_id" => "required",
            "taxmode_id" => "required",
            "clasificacion_sunat_id",
            "currency_id" => "required",
            "name" => "required|unique:products,name,NULL,id,company_id," . $this->input('company_id'),
            "model" => "sometimes",
            "url" => "required",
            "image" => "required|image|dimensions:min_width=200,min_height=200|mimes:png,jpg|max:300",
            "set_mode" => "required",
            "detail" => "required",
            "minimal" => "required",
            "price" => "required",
            "status",
        ];
    }
}
