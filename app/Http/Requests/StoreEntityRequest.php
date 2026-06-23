<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mode' => ['required', 'string'],
            'ruc' => ['required', 'string'],
            'razon_social' => ['required', 'string'],
            'ubigeo' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
        ];
    }
}
