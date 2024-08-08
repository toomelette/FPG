<?php

namespace App\Http\Requests\Hru;

use App\Models\HRU\PayrollMasterDetails;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class PayrollRefundFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
            'refund_amount' => [
               'required',
               'string',
                function ($attr,$value,$fail) {
                    $payrollDetail = PayrollMasterDetails::query()->findOrFail($this->route('payroll_refund'));
                    if(Helper::sanitizeAutonum($value) > $payrollDetail->amount){
                        $fail("Refund amount must be lower than the original amount.");
                    }
                }
            ],
            'refund_date' => 'required_with:refund_amount|date_format:Y-m-d',
            'refund_remarks' => 'nullable|string|max:255',
        ];
    }
}