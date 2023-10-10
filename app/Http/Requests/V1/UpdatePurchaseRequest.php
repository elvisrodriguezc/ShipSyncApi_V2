<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
            'warehouse_id' => "sometimes",
            'entity_id' => "sometimes",
            'receipttype_id' => "sometimes",
            'document_serial' => "sometimes",
            'document_number' => "sometimes",
            'guide_number' => "sometimes",
            'date' => "sometimes",
            'credit'  => "sometimes",
            'duedate' => "sometimes",
            'status' => "sometimes"
        ];
    }
}
