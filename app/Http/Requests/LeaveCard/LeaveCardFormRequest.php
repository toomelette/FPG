<?php

namespace App\Http\Requests\LeaveCard;

use App\Models\HRU\LeaveApplicationDates;
use App\Models\LeaveCard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LeaveCardFormRequest extends FormRequest{
    



    public function authorize(){

        return true;
    
    }






    public function rules(){
        $rules = [
            'date' => 'required|date_format:Y-m-d',
            'credits' => ['required','numeric'],
        ];
        if($this->route('leaveType') == 'CTO'){
            $max = 40;
            $employeeSlug = $this->route('employeeSlug');
            $leaveType = $this->route('leaveType');
            $month = Str::of($this->get('date'))->beforeLast('-');
            $credits = LeaveCard::query()
                ->where('leave_card','=',$leaveType)
                ->where('employee_slug','=',$employeeSlug)
                ->where('date','like',$month.'%')
                ->sum('credits');
            $rules['credits'] = [
                'required',
                'numeric',
                function ($attr,$value,$fail) use($credits,$max) {
                if(($credits + $this->get('credits')) > $max)
                    $fail('Stored CTO credits including this will exceed the '.$max.' hours limit per month. Max allowed: '.$max-$credits);
                }
            ];

        }
        return $rules;
    
    }





}
