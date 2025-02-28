<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;

class PSUpdateTimeFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
           'departure' => 'required_unless:return,null',
            'return' => [
                'nullable',
                function ($attr,$value,$fail) {
                    if($value <= $this->departure){
                        $fail('Return field must be later than departure field.');
                    }
                }
            ],
        ];
    }
}