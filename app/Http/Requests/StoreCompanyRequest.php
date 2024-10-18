<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('companies')],
            'address' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('companies')],
            'website' => ['required', 'string', Rule::unique('companies')],
            'number_of_employees' => ['required', 'numeric', 'min:1'],
            'sector_id' => ['required', Rule::exists('sectors', 'id')],
        ];
    }
}
