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
                $oa = new HrOtherActions();
                $oa->employee_slug = $slug;
                $oa->type = $type;
                $oa->values = $request->all();
                $oa->save();
                return \view('printables.employee.nosa-hrs-034-02')->with([
                    'employee' => $employee,
                ]);

            default:
                break;
        }
    }
}