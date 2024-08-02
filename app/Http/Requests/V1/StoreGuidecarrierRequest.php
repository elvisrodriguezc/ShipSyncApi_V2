<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuidecarrierRequest extends FormRequest
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
            "company_id" => 'sometimes',
            "user_id" => 'sometimes',
            "numerator_id" => 'required',
            "serie" => 'sometimes',
            "number" => 'sometimes',
            "release_date" => 'required',
            "transfer_date" => 'sometimes',
            "sender_id" => 'required',
            "senderbranch_id" => 'required',
            "destination_id" => 'required',
            "destinationbranch_id" => 'required',
            "driver_id" => 'required',
            "vehicle_id" => 'required',
            "tercero_id" => 'sometimes',
            "subcontratado_id" => 'sometimes',
            "tipoindicador_id" => 'required',
            "pesobruto" => 'required',
            "nota" => 'sometimes',
            "numTicket" => 'sometimes',
            "fecRecepcion" => 'sometimes',
            "codRespuesta" => 'sometimes',
            "indCdrGenerado" => 'sometimes',
            "numError" => 'sometimes',
            "desError" => 'sometimes',
            "hash" => 'sometimes',
            "status" => "sometimes",
        ];
    }
}
