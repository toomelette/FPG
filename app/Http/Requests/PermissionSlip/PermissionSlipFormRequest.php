<?php

namespace App\Http\Requests\PermissionSlip;

use Illuminate\Foundation\Http\FormRequest;

class PermissionSlipFormRequest extends FormRequest{


    
    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [

//            'employee_no' => 'required|max:20|string',
            'date' => 'required|date_format:"Y-m-d"',

            
        ];
    
    }




}
