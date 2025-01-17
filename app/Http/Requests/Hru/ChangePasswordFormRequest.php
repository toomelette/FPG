<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
            'old_pass' => [
                'required',
                function ($attr,$value,$fail) {
                    if(!\Hash::check($value,\Auth::user()->password)){
                        $fail('Incorrect Password.');
                    }
                }
            ],
            'new_pass' => [
                'required',
                function ($attr,$value,$fail) {
                    if(\Hash::check($value,\Auth::user()->password)){
                        $fail('New password cannot be the same as your old password.');
                    }
                }
            ],
            'new_pass2' => [
                'required',
                function ($attr,$value,$fail) {
                    if($value !== $this->get('new_pass')){
                        $fail('Password does not match.');
                    }
                }
            ],
        ];
    }
}