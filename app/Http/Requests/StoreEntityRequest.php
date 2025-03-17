<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
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
            'mode' => ['required', 'string'],
            'ruc' => ['required', 'string'],
            'razon_social' => ['required', 'string'],
            'estado' => ['required', 'string'],
            'condicion' => ['required', 'string'],
            'ubigeo' => ['required', 'string'],
            'tipo_via' => ['required', 'string'],
            'nombre_via' => ['required', 'string'],
            'codigo_zona' => ['required', 'string'],
            'tipo_zona' => ['required', 'string'],
            'numero' => ['required', 'string'],
            'interior' => ['required', 'string'],
            'lote' => ['required', 'string'],
            'departamento' => ['required', 'string'],
            'manzana' => ['required', 'string'],
            'kilometro' => ['required', 'string'],
        ];
    }
}
