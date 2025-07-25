<?php

namespace App\Http\Controllers\HRU;

use App\Http\Requests\Hru\EmployeeTimeLogsFormRequest;
use App\Models\HRU\EmployeeTimeLogs;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EmployeeTimeLogsController
{
    public function create(Request $request)
    {
        return view('_hru.employee-time-logs.create');
    }

    public function store(EmployeeTimeLogsFormRequest $request)
    {
        $timeLogs = new EmployeeTimeLogs();
        $timeLogs->slug = Str::random();
        $timeLogs->employee_slug = $request->employee_slug;
        $timeLogs->date = $request->date;
        $timeLogs->am_in = $request->am_in;
        $timeLogs->pm_out = $request->pm_out;
        if($timeLogs->save()){
            return $timeLogs->only('slug');
        }
        abort(503, 'Error saving time logs.');
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $logs = EmployeeTimeLogs::query()
                ->with(['employee']);
            return DataTables::of($logs)
                ->addColumn('details',function ($data){

                })
                ->editColumn('date',function($data){
                    return Helper::dateFormat($data->date,'M. d, Y');
                })
                ->editColumn('am_in',function($data){
                    return Helper::dateFormat($data->am_in,'h:i A');
                })
                ->editColumn('pm_out',function($data){
                    return Helper::dateFormat($data->pm_out,'h:i A');
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.employee-time-logs.index');
    }
}