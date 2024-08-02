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
            "name" => "required|unique:products,brand_id,NULL,id,company_id," . $this->input('company_id'),
            "detail" => "sometimes",
            "barcode" => "sometimes",
            "category_id" => "required",
            "unity_id" => "required",
            "model" => "sometimes",
            "url" => "required",
            "image" => "sometimes|image|dimensions:min_width=200,min_height=200|mimes:jpeg,png,jpg,gif",
            "set_mode" => "required",
            "currency_id" => "required",
            "price" => "required",
            "minimal" => "required",
            "brand_id" => "required",
            "taxmode_id" => "required",
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
