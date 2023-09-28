<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
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
            'name' => 'sometimes|required|string',
            'enabled' => 'sometimes|required|boolean',
            'statement_map' => 'sometimes|array:bank_account_id,header_lines,date_column,description_column,amount_is_split,amount_column,amount_2_column,created_at,updated_at',
            'statement_map.header_lines' => 'sometimes|integer',
            'statement_map.date_column' => 'sometimes|integer',
            'statement_map.description_column' => 'sometimes|integer',
            'statement_map.amount_is_split' => 'sometimes|boolean',
            'statement_map.amount_column' => 'sometimes|integer',
            'statement_map.amount_2_column' => 'sometimes|required_if:statement_map.amount_is_split,true|integer|nullable',
        ];
    }
}
