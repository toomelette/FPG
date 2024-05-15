<?php

namespace App\Http\Requests\Plantilla;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlantillaFormRequest extends FormRequest{
   



    public function authorize(){

        return true;
    
    }





    public function rules(){

        return [
            'item_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hr_pay_plantilla','item_no')->ignore($this->request->get('id'),'item_no'),
            ],
            'position' => 'required|string|max:255',
            'job_grade' => 'required|int|max:50',
            'step_inc' => 'required|int|max:8',
            'employee_no' => [
                'nullable',
                'string',
                Rule::exists('hr_employees','employee_no'),
            ],
            'qs_education' => 'nullable|string|max:512',
            'qs_training' => 'nullable|string|max:512',
            'qs_experience' => 'nullable|string|max:512',
            'qs_eligibility' => 'nullable|string|max:512',
            'qs_competency' => 'nullable|string|max:512',
            'place_of_assignment' => 'nullable|string|max:255',
        ];
    
    }




}
