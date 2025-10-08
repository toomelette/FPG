<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class HRRequestsFromRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        if(Str::of($this->document)->contains('Contract of Service')){

        }
        $rules = [
           'document' => 'required|string|max:225',
            'purpose' => 'required|string|max:255',
        ];
        if(Str::of($this->document)->contains('Contract of Service')){
            unset($rules['purpose']);
            $rules['doc_file'] = 'required|mimes:pdf|max:10000';
        }
        return $rules;
    }
}