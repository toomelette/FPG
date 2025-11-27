<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HRU\HrOtherActions;
use Illuminate\Http\Request;

class OtherActionsController extends Controller
{
    public function index($employeeSlug)
    {
        $employee = Employee::query()->findOrFail($employeeSlug);
        return view('_hru.employee.other-hr-actions.index')->with([
            'employee' => $employee,
        ]);
    }

    public function print($slug,$type,Request $request)
    {
        $employee = Employee::query()->findOrFail($slug);
        switch ($type){
            case 'coe':
                return view('printables.employee.coe')->with([
                    'employee' => $employee,
                ]);
            case 'coec':
                return \view('printables.employee.coe_with_compensation')->with([
                    'employee' => $employee,
                ]);
            case 'nosa':
               return \view('printables.employee.nosa-hrs-034-02')->with([
                    'employee' => $employee,
                    'request' => $request,
                ]);
            case 'nosi':
                return view('printables.employee.nosi-hrs-033-03')->with([
                    'employee' => $employee,
                ]);

            default:
                break;
        }
    }
}