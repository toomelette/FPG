<?php

namespace App\Http\Requests\LeaveCard;

use Illuminate\Foundation\Http\FormRequest;

class LeaveCardBegBalFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
           'as_of' => 'required|date_format:"Y-m-d"',
        ];
    }
}