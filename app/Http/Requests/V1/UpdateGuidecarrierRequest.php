<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuidecarrierRequest extends FormRequest
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
            "numerator_id" => 'sometimes',
            "number" => 'sometimes',
            "release_date" => 'sometimes',
            "transfer_date" => 'sometimes',
            "sender_id" => 'sometimes',
            "senderbranch_id" => 'sometimes',
            "destination_id" => 'sometimes',
            "destinationbranch_id" => 'sometimes',
            "driver_id" => 'sometimes',
            "vehicle_id" => 'sometimes',
            "tercero_id" => 'sometimes',
            "subcontratado_id" => 'sometimes',
            "tipoindicador_id" => 'sometimes',
            "pesobruto" => 'sometimes',
            "nota" => 'sometimes',
            "numTicket" => 'sometimes',
            "fecRecepcion" => 'sometimes',
            "codRespuesta" => 'sometimes',
            "indCdrGenerado" => 'sometimes',
            "numError" => 'sometimes',
            "desError" => 'sometimes',
            "hash" => 'sometimes',
            "status" => 'sometimes',
        ];
    }
}
