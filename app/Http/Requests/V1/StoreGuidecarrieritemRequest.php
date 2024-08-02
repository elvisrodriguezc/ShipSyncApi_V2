<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuidecarrieritemRequest extends FormRequest
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
            "guidecarrier_id" => "required",
            "product_id" => "required",
            "quantity" => "required",
            "unity_id" => "required",
            "unitvalue" => "sometimes",
            "duscount" => "sometimes",
            "mto_baseigv" => "sometimes",
            "porcentaje_igv" => "sometimes",
            "total_impuestos" => "sometimes",
            "monto_preciounitario" => "sometimes",
            "status" => "sometimes",
        ];
    }
}
