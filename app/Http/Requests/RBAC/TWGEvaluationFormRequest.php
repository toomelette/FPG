<?php

namespace App\Http\Requests\RBAC;

use Illuminate\Foundation\Http\FormRequest;

class TWGEvaluationFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
            'concat_items' => 'required',
            'abc' => 'required',
            'mode_of_procurement' => 'required',
            'justification' => 'required',
        ];
    }
}