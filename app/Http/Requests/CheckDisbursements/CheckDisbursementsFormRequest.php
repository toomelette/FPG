<?php

namespace App\Http\Requests\CheckDisbursements;

use Illuminate\Foundation\Http\FormRequest;

class CheckDisbursementsFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'date' => 'required|date_format:Y-m-d',
            'fund_source' => 'required|string|max:255',
            'payee' => 'required|string|max:255',
            'cd_no' => 'required|string|max:255',
            'remarks' => 'required|string|max:512',
            'jev_details.*.account_code' => 'required',
            'check_from' => 'required|string|max:255',
            'check_to' => 'required|string|max:255',

//            'jev_details.*.resp_center' => 'required',
            'jev_details.*.debit' => 'required_without:jev_details.*.credit|prohibited_unless:jev_details.*.credit,null',
            'jev_details.*.credit' => 'required_without:jev_details.*.debit|prohibited_unless:jev_details.*.debit,null',


        ];
    }

    public function messages(){
        return [
            'jev_details.*.debit.required_without' => 'Debit is required if Credit is empty.',
            'jev_details.*.credit.required_without' => 'Credit is required if Debit is empty.',
            'jev_details.*.debit.prohibited_unless' => 'Only either of Debit or Credit must be filled.',
            'jev_details.*.credit.prohibited_unless' => 'Only either of Debit or Credit must be filled.',

        ];
    }

}