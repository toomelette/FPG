<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;

class PayrollPreparationFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required',
        ];
    }
}