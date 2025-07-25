<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeTimeLogsFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
            'employee_slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hr_employee_time_logs')->where(function ($q){
                    $q->where('employee_slug','=',$this->employee_slug)
                        ->where('date','=',$this->date);
                })
            ],
            'date' => 'required',
            'am_in' => 'required_without:pm_out',
            'pm_out' => 'required_without:am_in',
        ];
    }
    public function messages()
    {
        return [
            'am_in.required_without' => 'AM IN or PM OUT must be filled.',
            'pm_out.required_without' => 'AM IN or PM OUT must be filled.',
            'employee_slug.unique' => 'Time logs already exist for this employee on the date chosen below.'
        ];
    }
}