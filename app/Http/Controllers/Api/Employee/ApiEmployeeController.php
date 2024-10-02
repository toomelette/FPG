<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\Api\User;
use App\Models\Employee;
use App\Models\PPU\Pap;
use Carbon\Carbon;
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

    public function all(Request $request){
        $employees = Employee::query()
            ->with([
                'plantilla',
            ]);
        if($request->has('active')){
            $employees->active();
        }
        if($request->has('permanent')){
            $employees->permanent();
        }
        if($request->has('cos')){
            $employees->cos();
        }
        $employees = $employees->get();
        return $employees->map(function ($data){
            return [
                'slug' => $data->slug,
                'employee_no' => $data->employee_no,
                'full' => $data->full,
                'lastname' => $data->lastname,
                'firstname' => $data->firstname,
                'middlename' => $data->middlename,
                'ext' => $data->ext,
                'sex' => $data->sex,
                'date_of_birth' => $data->date_of_birth,
                'position' => $data->plantilla->position ?? $data->position,
                'item_no' => $data->item_no,
                'firstday_gov' => $data->firstday_gov,
                'years_in_gov' => Carbon::parse($data->firstday_gov)->age,
                'firstday_sra' => $data->firstday_sra,
                'location' => $data->locations,
                'height' => $data->height,
                'weight' => $data->weight,
                'blood_type' => $data->blood_type,
            ];
        });
    }

    public function store(Request $request){
        return $request->all();
    }

}