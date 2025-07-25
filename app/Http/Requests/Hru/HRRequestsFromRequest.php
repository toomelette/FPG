<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;

class HRRequestsFromRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
           'document' => 'required|string|max:225',
            'purpose' => 'required|string|max:255',
        ];
    }
}