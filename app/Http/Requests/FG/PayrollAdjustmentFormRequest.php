<?php

namespace App\Http\Requests\FG;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayrollAdjustmentFormRequest extends FormRequest
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
            'code' => [
                'required',
                Rule::unique('payroll_adjustments','code')->ignore($this->route('payroll_adjustment'),'id')
            ],
            'description' => 'required',
            'type' => 'required',
            'priority' => [
                'required',
                Rule::unique('payroll_adjustments','priority')->ignore($this->route('payroll_adjustment'),'id')
            ],
        ];

        if($this->getMethod() == 'PATCH' || $this->getMethod() == 'PUT'){
            unset($rules['code']);
        }
        return  $rules;
    }
}
