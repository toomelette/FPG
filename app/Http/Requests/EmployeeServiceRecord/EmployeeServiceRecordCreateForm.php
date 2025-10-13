<?php

namespace App\Http\Requests\EmployeeServiceRecord;

use App\Models\EmployeeServiceRecord;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeServiceRecordCreateForm extends FormRequest{


    public function authorize(){

        return true;
    
    }


    public function prepareForValidation()
    {
        $this->merge([
            'monthly_basic' => Helper::sanitizeAutonum($this->monthly_basic),
        ]);
    }

    public function rules(){

        $rules = [
            'sequence_no'=>[
                'required',
                'int',
                Rule::unique('hr_employee_service_records','sequence_no')
                    ->where('employee_slug',$this->route('slug'))
            ],
            'from_date'=>'required|date|max:45',
            'to_date'=>'nullable|date|max:45',
//            'to_date'=>'nullable|date|max:45',
            'position'=>'required|string|max:45',
            'appointment_status'=>'required|string|max:45',
            'salary'=>'required|string|max:13',
            'mode_of_payment'=>'required|string|max:45',
            'station'=>'required|string|max:45',
            'gov_serve'=>'nullable|string|max:45',
            'psc_serve'=>'nullable|string|max:45',
            'lwp'=>'nullable|string|max:20',
            'spdate'=>'nullable|string|max:20',
            'status'=>'nullable|string|max:90',
            'remarks'=>'nullable|string|max:200',
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
        ];
        if($this->due_to == 'NOSI'){
              $prevSr = EmployeeServiceRecord::query()
                ->where('employee_slug','=',$this->route('slug'))
                ->where('sequence_no','<',$this->sequence_no ?? 0)
                ->orderBy('sequence_no','desc')
                ->first();
            if(!empty($prevSr)){
                $rules['grade'][] = 'in:'.$prevSr->grade;
                $rules['step'][] = 'gt:'.$prevSr->step;
            }
        }

        if($this->has('update')){
            $rules = [
                'sequence_no'=>'required|int|max:1000',
                'from_date'=>'required|string|max:45',
                'to_date'=>'nullable|string|max:45',
                'position'=>'required|string|max:45',
                'appointment_status'=>'required|string|max:45',
                'salary'=>'required|string|max:13',
                'mode_of_payment'=>'required|string|max:45',
                'station'=>'required|string|max:45',
                'gov_serve'=>'nullable|string|max:45',
                'psc_serve'=>'nullable|string|max:45',
                'lwp'=>'nullable|string|max:20',
                'spdate'=>'nullable|string|max:20',
                'status'=>'nullable|string|max:90',
                'remarks'=>'nullable|string|max:200',
                'salary_type' => 'required_with:grade,step',
                'grade' => 'required_with:step,salary_type',
                'step' => 'required_with:grade,salary_type',
                'monthly_basic' => 'required|numeric',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'grade.in' => 'Salary grade must not be the changed in NOSI',
        ];
    }

}
