<?php

namespace App\Http\Requests\Submenu;

use Illuminate\Foundation\Http\FormRequest;

class SubmenuFormRequestEdit extends FormRequest{


    public function authorize(){

        return true;
    }




    public function rules(){

        return [

            'name' => 'required|string|max:45',
            'route' => 'nullable|string|max:45',
            'nav_name' => 'nullable|string|max:255',
            'is_nav' => 'nullable|int|max:3',
        ];

    }





}
