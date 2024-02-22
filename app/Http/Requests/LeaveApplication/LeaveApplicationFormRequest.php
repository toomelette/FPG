<?php

namespace App\Http\Requests\LeaveApplication;

use Illuminate\Foundation\Http\FormRequest;

class LeaveApplicationFormRequest extends FormRequest{




    
    public function authorize(){

        return true;
    }

    



    public function rules(){
            

        $rules = [
            'employee_slug'=>'required|string|max:90',
            'lastname'=>'required|string|max:90',
            'middlename'=>'required|string|max:90',
            'date_of_filing'=>'required|date_format:"Y-m-d"',
            'position'=>'required|string|max:90',
            'salary'=>'required|string|max:13',
            'immediate_superior'=>'nullable|string|max:90',
            'immediate_superior_position'=>'nullable|string|max:90',
            'leave_type'=>'required|string|max:255',
            'leave_details' => 'sometimes|string|max:255',
            'leave_specify' => 'sometimes|string|max:255',
            'no_of_days'=>'required|string|max:45',
            'department'=>'required|string|max:45',
            'inclusive_dates'=>'required|string',
            'commutation'=>'required|string|max:15',
            'approved_by'=>'required|string|max:90',
            'approved_by_position'=>'required|string|max:90',
        ];

        if($this->request->get('leave_type') == 'Others'){
            $rules['leave_type_specify'] = 'required|string|max:255';
        }
        return $rules;

    }









}
