<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
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
            'office_id' => 'sometimes|required',
            'name' => 'sometimes|required|unique:warehouses,name',
            'detail' => 'sometimes',
            'warehouse_id' => 'sometimes|required',
            'isproduction' => 'sometimes|required',
            'status' => 'sometimes|required',
        ];
    }
}
