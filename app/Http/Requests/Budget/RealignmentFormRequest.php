<?php

namespace App\Http\Requests\Budget;

use Illuminate\Foundation\Http\FormRequest;

class RealignmentFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'source_pap' => 'sometimes|required',
            'destination_pap' => 'sometimes|required',
            'type' => 'sometimes|required',
            'amount' => 'sometimes|required',
        ];
    }
}