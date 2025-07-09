<?php

namespace App\Http\Requests\Hru;

use Illuminate\Foundation\Http\FormRequest;

class TimekeepingFormRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'month' => 'required|string',
            'dates.*.day' => 'required|string|distinct',
            'dates.*.am_in' => 'required_without_all:dates.*.am_out,dates.*.pm_in,dates.*.pm_out',
            'dates.*.am_out' => 'required_without_all:dates.*.am_in,dates.*.pm_in,dates.*.pm_out',
            'dates.*.pm_in' => 'required_without_all:dates.*.am_in,dates.*.am_out,dates.*.pm_out',
            'dates.*.pm_out' => 'required_without_all:dates.*.am_in,dates.*.am_out,dates.*.pm_in',
        ];
    }

    public function messages()
    {
        return [
            'dates.*.day.distinct' => 'You have selected a duplicate date.',
            'dates.*.*.required_without_all' => 'At least one field is required.',
        ];
    }
}