<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\Api\User;
use App\Models\Employee;
use Illuminate\Http\Request;


class ApiEmployeeController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }
    public function getByEmployeeNo($employee_no){

        $employee = Employee::query()
            ->where('employee_no','=',$employee_no)
            ->first();
        return $employee ?? abort(404);
    }

    public function all(){
        $employee = Employee::query()->get();
        return $employee->toJson();
    }

    public function store(Request $request){
        return $request->all();
    }

}