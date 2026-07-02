<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class CashAdvancesFormRequest extends FormRequest
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
        if($this->has('approve')){
            $this->merge([
                'amount_approved' => Helper::sanitizeAutonum($this->amount_approved) * 1,
            ]);
        }else{
            $this->merge([
                'amount_requested' => Helper::sanitizeAutonum($this->amount_requested) * 1,
            ]);
        }


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->has('approve')){
            return  [
                'amount_approved' => 'required',
            ];
        }

        return [
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required',
            'reason' => 'required',
            'requested_by' => 'required',
            'amount_requested' => 'required|numeric|gt:0',
        ];
    }
}
