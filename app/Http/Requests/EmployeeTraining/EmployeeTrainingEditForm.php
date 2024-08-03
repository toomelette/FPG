<?php

namespace App\Http\Requests\EmployeeTraining;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeTrainingEditForm extends FormRequest{
    


    public function authorize(){

        return true;
    
    }

    



    public function rules(){

        return [
            
        	'title'=>'required|string|max:250',
            'type'=>'nullable|string|max:45',
            'date_from'=>'nullable|date_format:"Y-m-d"',
            'date_to'=>'nullable|date_format:"Y-m-d"',
            'hours'=>'required|int|max:100000',
            'conducted_by'=>'nullable|string|max:250',
            'venue'=>'nullable|string|max:250',
            'remarks'=>'nullable|string|max:250',
            'is_relevant'=>'nullable|string|max:11',

        ];
    
    }




}
