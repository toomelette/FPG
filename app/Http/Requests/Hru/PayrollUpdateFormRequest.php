<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;

class PayrollUpdateFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        if($this->has('import')){
            return [
                'type' => 'required|string',
                'file' => 'required|mimes:xls,xlsx',
            ];
        }
        if($this->has('signatories')){
            return [
                'a_name' => 'required|string|max:255',
                'a_position' => 'required|string|max:255',
                'b_name' => 'required|string|max:255',
                'b_position' => 'required|string|max:255',
                'c_name' => 'required|string|max:255',
                'c_position' => 'required|string|max:255',
                'd_name' => 'required|string|max:255',
                'd_position' => 'required|string|max:255',
            ];
        }
        return  [];
    }
}