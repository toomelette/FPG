<?php

namespace App\Http\Requests\Submenu;

use Illuminate\Foundation\Http\FormRequest;

class SubmenuFormRequest extends FormRequest{


    public function authorize(){

        return true;
    }




    public function rules(){

        return [
            'name' => 'required|string|max:45',
            'route' => 'required|string|max:95',
            'nav_name' => 'nullable|string|max:45',
            'is_nav' => 'nullable|int|max:3',
        ];

    }





}
