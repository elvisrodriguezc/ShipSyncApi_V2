<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'company_id',
            'warehouse_id' => "required",
            'entity_id' => "required",
            'receipttype_id' => "required",
            'document_serial' => "required",
            'document_number' => "required",
            'guide_number',
            'date' => "required",
            'credit' => "required",
            'duedate'
        ];
    }
}
