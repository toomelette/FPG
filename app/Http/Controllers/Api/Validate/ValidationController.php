<?php

namespace App\Http\Controllers\Api\Validate;

use App\Models\Employee;
use Illuminate\Http\Request;

class ValidationController
{
    public function bmuid(Request $request)
    {
        $emp = Employee::query()
            ->where('biometric_user_id','=',$request->all()['bmuid'])
            ->where('biometric_user_id','!=',0)
            ->count();
        return $emp;
    }

    public function employeeNo(Request $request)
    {
        $emp = Employee::query()
            ->where('employee_no','=',$request->all()['employee_no'])
            ->count();
        return $emp;
    }
}