<?php

namespace App\Http\Requests\PermissionSlip;

use Illuminate\Foundation\Http\FormRequest;

class PermissionSlipFormRequest extends FormRequest{


    
    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'personal_official' => 'required',
            'direct_nondirect' => 'required',
            'purpose' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'mode_of_transportation' => 'required',
            'supervisor_name' => 'required|string|max:255',
            'supervisor_position' => 'required|string|max:255',
        ];
        //if store
        if( $this->method() == 'POST'){
            if(empty($this->employees) || count($this->employees) < 1){
                abort(503,'There must be at least one employee.');
            }
            $rules['employees.*'] = 'required';
        }

        return $rules;
    
    }




}
