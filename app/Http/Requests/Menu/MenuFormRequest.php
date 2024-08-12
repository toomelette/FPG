<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){


        $rules = [
            
            'name'=>'required|string|max:45',
            'route'=>'required|string|max:45',
//            'icon'=>'required|string|max:45',
            'category'=>'required|string|max:45',
            'is_menu'=>'nullable|string|max:11',
            'is_dropdown'=>'nullable|string|max:5',
            'portal' => 'required',
        ];



        return $rules;

    }







}
