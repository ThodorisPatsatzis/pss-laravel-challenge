<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('companies')->ignore($this->company->id)],
            'address' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('companies')->ignore($this->company->id)],
            'website' => ['required', 'string', Rule::unique('companies')->ignore($this->company->id)],
            'number_of_employees' => ['required', 'numeric', 'min:1'],
            'sector_id' => ['required', Rule::exists('sectors', 'id')],
        ];
    }
}
