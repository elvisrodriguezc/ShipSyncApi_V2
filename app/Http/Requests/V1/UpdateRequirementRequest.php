<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequirementRequest extends FormRequest
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
            "warehouse_id" => "sometimes",
            "user_id" => "sometimes",
            "numerator_id" => "sometimes",
            "number" => "sometimes",
            "currency_id" => "sometimes",
            "relevance_id" => "sometimes",
            "updatedby_id" => "sometimes",
            "deadline" => "sometimes",
            "status" => "sometimes",
        ];
    }
}
