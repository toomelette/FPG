<?php

namespace App\Http\Requests\Hru;

use App\Models\HRU\PayrollMaster;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PayrollPreparationFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    
    public function rules(){
        return [
            'date' => 'required|date_format:Y-m',
            'type' => [
                'required',
                'string',
                function ($attr, $value, $fail) {
                    $payrollMaster = PayrollMaster::query()
                        ->where('date','=',$this->date.'-01')
                        ->where('type','=',$this->type)
                        ->count();
                    if($payrollMaster > 0){
                        $fail('You have already created a '.$this->type.' payroll for '.Carbon::parse($this->date.'-01')->format('F Y'));
                    }
                }
            ],
        ];
    }
}