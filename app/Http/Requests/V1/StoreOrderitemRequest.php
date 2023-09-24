<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderitemRequest extends FormRequest
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
            "order_id" => "required",
            "tariffitem_id" => "required",
            "product_serie_id",
            "quantity" => "required",
            "price" => "required",
            "discount" => "",
            "discount_percent",
            "description" => "sometimes",
            "splitfrom" => "",
            "status_comment" => "sometimes",
            "status" => ""
        ];
    }
}
