<?php


namespace App\Http\Requests\MisRequests;


use Illuminate\Foundation\Http\FormRequest;

class MisRequestsFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'nature_of_request' => 'required|string|exists:mis_requests_nature,slug',
            'details' => 'nullable|max:254',
            'email' => 'required|email',
        ];
    }
}