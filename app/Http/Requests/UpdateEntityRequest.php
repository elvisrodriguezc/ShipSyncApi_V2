<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mode' => ['sometimes', 'string'],
            'ruc' => ['sometimes', 'string'],
            'razon_social' => ['sometimes', 'string'],
            'ubigeo' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
        ];
    }
}
