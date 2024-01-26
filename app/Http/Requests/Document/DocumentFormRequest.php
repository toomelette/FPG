<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }






    public function rules(){
        if($this->getRealMethod() == 'POST'){
            $for_doc = 'required|mimes:pdf,jpeg,jpg,png|max:50000';
        }
        if($this->getRealMethod() == 'PATCH'){
            $for_doc = 'nullable|mimes:pdf,jpeg,jpg,png|max:50000';
        }

        return [
//            'doc_file' => 'required|max:50000',
            'doc_file' => $for_doc,
            'reference_no' => [
                'required',
                'max:45',
                'alpha_dash',
                Rule::unique('rec_documents','reference_no')
                    ->ignore($this->get('slug'),'slug')
                    ->where('deleted_at',null),

            ],
            'date' => 'required|date_format:"Y-m-d"',
            'person_to' => 'nullable|max:90|string',
            'person_from' => 'nullable|max:90|string',
            'type' => 'required|max:45|string',
            'subject' => 'required|max:255|string',
            'folder_code' => 'required|max:45|string',
            'folder_code2' => 'nullable|max:45|string|different:folder_code',
            'remarks' => 'nullable|max:255|string',

        ];
    
    }




}
