<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class PettyCashLiquidationsFormRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $this->merge([
            'total_amount' => Helper::sanitizeAutonum($this->total_amount) * 1,
            'approved_amount' => Helper::sanitizeAutonum($this->approved_amount) * 1,
        ]);
    }

    public function rules(): array
    {
        if($this->has('takeAction')){
            $rules = [
                'radio' => 'required',
            ];
            if($this->radio == 'approve'){
                $rules['cv_no'] = 'required';
                $rules['approved_amount'] = 'required|gt:0';
            }
            return $rules;
        }
        return [
            'date' => 'required|date_format:Y-m-d',
            'total_amount' => 'required|gt:0',
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480'
            ],
        ];
    }
}
