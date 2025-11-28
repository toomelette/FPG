<?php

namespace App\Http\Requests\Hru;

use App\Models\HRU\PayrollMaster;
use Carbon\Carbon;
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

        if($this->has('saveAs')){

            $currentMaster = PayrollMaster::query()->findOrFail($this->route('slug'));

            return [
                'month' => [
                    'required',
                    'date_format:Y-m',
                    function ($attr, $value, $fail) use($currentMaster) {
                        $payrollMaster = PayrollMaster::query()
                            ->where('date','=',$this->month.'-01')
                            ->where('type','=',$currentMaster->type)
                            ->count();
                        if($payrollMaster > 0){
                            $fail('You have already created a '.$currentMaster->type.' payroll for '.Carbon::parse($this->month.'-01')->format('F Y'));
                        }
                    }
                ],
            ];
        }
        return  [];
    }
}