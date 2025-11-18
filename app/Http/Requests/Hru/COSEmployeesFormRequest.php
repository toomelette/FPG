<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class COSEmployeesFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {
        if($this->has('multiple')){
            return [];
        }
        return [
            'employee_slug' => [
                'required',
                Rule::unique('hr_cos_employees')
                ->where(function ($q){
                    $q->where('cos_slug',$this->route('slug'));
                })
            ],
        ];
    }

    public function messages()
    {
        return [
            'employee_slug.unique' => 'This employee already exists in this listing.',
        ];
    }
}