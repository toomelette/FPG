<?php

namespace App\Http\Requests\Hru;

use App\Models\HRU\PayrollMaster;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PayrollPreparationFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH'){
            $adjustments = collect($this->data ?? []);
            $adjustments = $adjustments->map(function ($adjustments){
                $new = [];
                foreach ($adjustments as $code => $adjustment){
                    $new[$code] = Helper::sanitizeAutonum($adjustment) * 1;
                }
                return $new;
            })
                ->filter(function ($value){
                    return !empty($value);
                });

            $this->merge([
                'data' => $adjustments->toArray(),
            ]);
        }
    }

    public function rules(){
        if($this->getMethod() == 'POST'){
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

        if($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH'){
            return [];
        }
    }
}