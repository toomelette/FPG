<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentDisseminationRequest extends FormRequest{




    
    public function authorize(){

        return true;
    
    }





    public function rules(){

        $rules = [
            
        	'employee'=>'nullable|array',
            'email_contact'=>'nullable|array',
            'subject'=>'required|string|max:255',
            'content'=>'nullable|string|max:10000',

        ];

//        if(!empty($this->request->get('employee'))){
//            foreach($this->request->get('employee') as $key => $value){
//                $rules['employee.'.$key] = 'string|max:45';
//            }
//        }
//
//        if(!empty($this->request->get('email_contact'))){
//            foreach($this->request->get('email_contact') as $key => $value){
//                $rules['email_contact.'.$key] = 'string|max:45';
//            }
//        }

        return $rules;

    }



}
