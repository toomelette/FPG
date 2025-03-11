<?php

namespace App\Http\Controllers\Api\DTR;

use App\Http\Controllers\Controller;
use App\Models\CronLogs;
use App\Models\DTR;
use App\Models\Employee;
use Illuminate\Http\Request;

class ApiQC_DTRController extends Controller
{
    public function accept(Request $request)
    {
        $dtrsToInsert = [];

        foreach ($request['dtrs'] as $dtr){
            $dtrsToInsert[] = [
                'lgarec_id' => $dtr['lgarec_id'],
                'uid' => $dtr['uid'],
                'user' => $dtr['user'],
                'state' => $dtr['state'],
                'type' => $dtr['type'],
                'timestamp' => $dtr['timestamp'],
                'device' => $dtr['device'],
//                'created_at' => \Carbon::now(),
                'location' => $dtr['location'],
            ];
        }

        $dtr = DTR::query()->insert($dtrsToInsert);
        return 1;
        dd($request->all());
    }

    public function updateBiometricId(Request $request)
    {
        $employeesFromRequest = collect($request->employees);
        $employeeNos = $employeesFromRequest->pluck('employee_no');

        $employees = Employee::query()
            ->whereIn('employee_no',$employeeNos)
            ->luzMin()
            ->get();

        if (!empty($employees)){
            foreach ($employees as $employee){
                $employee->biometric_user_id = $employeesFromRequest->where('employee_no',$employee->employee_no)->first()['biometric_user_id'];
                $employee->update();
            }
        }
        return [
            'message' => 'BMID of Employees successfully pushed to main.',
        ];
    }
}