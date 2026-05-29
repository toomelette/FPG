<?php

namespace App\Http\Requests\FG;

use Illuminate\Foundation\Http\FormRequest;

class SubsidiaryFormRequest extends FormRequest
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

        return [
            'subsidiary_ledger.*.account_code' => 'required',
            'subsidiary_ledger.*.debit'  => 'nullable|required_without:subsidiary_ledger.*.credit',
            'subsidiary_ledger.*.credit' => 'nullable|required_without:subsidiary_ledger.*.debit',
        ];
    }
}
