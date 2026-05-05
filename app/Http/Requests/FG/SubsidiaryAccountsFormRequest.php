<?php

namespace App\Http\Requests\FG;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubsidiaryAccountsFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'account_code' => [
                'required',
                'string',
                'starts_with:'.$this->route('parentAccountCode').'-',
                Rule::unique('subsidiary_accounts','account_code')
            ],

            'account_title' => 'required',
        ];
        if($this->getMethod() == 'PATCH' || $this->getMethod() == 'PUT'){
            unset($rules['account_code']);
        }
        return $rules;
    }
}
