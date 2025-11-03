<?php


namespace App\Http\Requests\News;


use Illuminate\Foundation\Http\FormRequest;

class NewsFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'title' => 'required|string|max:255',
            'details'=> 'required|string',
            'expires_on' => 'required|date_format:Y-m-d\TH:i',
            'author' => 'nullable|string|max:255',
            'author_position' => 'nullable|string|max:255',
        ];
    }
}