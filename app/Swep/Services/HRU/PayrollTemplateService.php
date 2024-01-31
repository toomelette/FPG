<?php

namespace App\Swep\Services\HRU;

use App\Models\Employee;

class PayrollTemplateService
{
    public function findEmployeeBySlug($slug){
        $employee = Employee::query()
            ->with(['templateIncentives.incentive','templateDeductions.deduction'])
            ->where('slug','=',$slug)->first();

        return $employee ?? abort(503,'Employee does not exist.');
    }

}