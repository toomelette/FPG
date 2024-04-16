<?php

namespace App\Http\Controllers\Api\Employee;

use App\Models\Api\User;
use App\Models\Employee;

class ApiEmployeeController
{
    public function getEmployeeByEmployeeNo($employee_no){
        $employee = Employee::query()->where('employee_no','=',$employee_no)->first();
        return $employee ?? abort(404);
    }

    public function getAll(){
        $employee = Employee::query()->get();
        return $employee->toJson();
    }
}