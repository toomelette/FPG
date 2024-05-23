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
            'route' => 'nullable|string|max:95',
            'nav_name' => 'nullable|string|max:45',
            'is_nav' => 'required|int|max:3',
            'menu_id' => 'required|string|max:45',
        ];

    }





}
