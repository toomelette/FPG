<?php


namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

class UserEditFormRequest extends FormRequest
{
    public function authorize(){

        return true;

    }



    public function rules(){


        $rules = [
//            'project_id' => 'required',
            'employee_sync'=>'nullable|string|max:45',
            'firstname'=>'nullable|string|max:90',
            'middlename'=>'nullable|string|max:90',
            'lastname'=>'nullable|string|max:90',
            'email'=>'nullable|string|email|max:90',
            'position'=>'nullable|string|max:90',

        ];


        return $rules;

    }
}