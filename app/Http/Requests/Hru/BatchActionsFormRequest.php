<?php

namespace App\Http\Requests\Hru;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class BatchActionsFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'monthly_basic' => Helper::sanitizeAutonum($this->monthly_basic),
        ]);
    }

    public function rules()
    {
        return [
            'item_no' => 'required|string',
            'salary_type' => 'required_with:grade,step',
            'grade' => [
                'int',
                'required_with:step,salary_type',
            ],
            'step' => [
                'int',
                'required_with:grade,salary_type'
            ],
            'monthly_basic' => 'required|numeric',
            'due_to'=>'required|string',
            'position'=>'required|string|max:45',
        ];
    }
}