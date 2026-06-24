<?php

namespace App\Http\Requests\FG;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'account_no' => '11000-'.$this->account_no,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'account_no' => [
                'required',
                'regex:/^11000\-\d{4}$/', // exactly 4 digits
                Rule::unique('clients','account_no'),
                Rule::unique('subsidiary_accounts','account_code')
            ],
        ];
    }
}
