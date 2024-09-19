<?php

namespace App\Http\Requests\Records;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequestFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        $rules = [
            'requesting_party' => 'required|string',
            'requested_records' => 'required|string',
            'purpose' => 'required|string',
            'requested_by' => 'required|string|max:255',
            'requested_by_position' => 'required|string|max:255',
        ];
        if($this->requesting_party == 'Other Government Agencies'){
            $rules['requesting_party_specify'] = 'required|string|max:255';
        }

        if($this->purpose == 'Others'){
            $rules['purpose_specify'] = 'required|string|max:255';
        }
        return $rules;
    }
}