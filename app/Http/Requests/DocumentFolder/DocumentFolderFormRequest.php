<?php

namespace App\Http\Requests\DocumentFolder;

use Illuminate\Foundation\Http\FormRequest;

class DocumentFolderFormRequest extends FormRequest{
    



    public function authorize(){
        
        return true;
    
    }

    



    public function rules(){

        $rules = [
            'folder_code' => 'required|max:45|string',
            'description' => 'required|max:255|string',
        ];


        if($this->getMethod() == 'PATCH'){
            $rules['folder_code'] = 'nullable';
        }
        return $rules;
    
    }





}
