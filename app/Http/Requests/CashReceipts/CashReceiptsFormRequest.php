<?php

namespace App\Http\Requests\CashReceipts;

use Illuminate\Foundation\Http\FormRequest;

class CashReceiptsFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'date' => 'required|date_format:Y-m-d',
            'fund_source' => 'required|string|max:255',
            'collecting_officer' => 'required|string|max:255',
            'rcd_no' => 'required|string|max:255',

            'jev_details.*.account_code' => 'required',
            'jev_details.*.resp_center' => 'required',
            'jev_details.*.debit' => 'required_without:jev_details.*.credit|prohibited_unless:jev_details.*.credit,null',
            'jev_details.*.credit' => 'required_without:jev_details.*.debit|prohibited_unless:jev_details.*.debit,null',

            'corollary_accounts.*.account_code' => 'required',
            'corollary_accounts.*.resp_center' => 'required',
            'corollary_accounts.*.debit' => 'required_without:corollary_accounts.*.credit|prohibited_unless:corollary_accounts.*.credit,null',
            'corollary_accounts.*.credit' => 'required_without:corollary_accounts.*.debit|prohibited_unless:corollary_accounts.*.debit,null',

        ];
    }

    public function messages(){
        return [
            'jev_details.*.debit.required_without' => 'Debit is required if Credit is empty.',
            'jev_details.*.credit.required_without' => 'Credit is required if Debit is empty.',
            'jev_details.*.debit.prohibited_unless' => 'Only either of Debit or Credit must be filled.',
            'jev_details.*.credit.prohibited_unless' => 'Only either of Debit or Credit must be filled.',

            'corollary_accounts.*.debit.required_without' => 'Debit is required if Credit is empty.',
            'corollary_accounts.*.credit.required_without' => 'Credit is required if Debit is empty.',
            'corollary_accounts.*.debit.prohibited_unless' => 'Only either of Debit or Credit must be filled.',
            'corollary_accounts.*.credit.prohibited_unless' => 'Only either of Debit or Credit must be filled.',
        ];
    }
}