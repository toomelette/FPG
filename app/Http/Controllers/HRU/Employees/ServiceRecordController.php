<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeServiceRecord\EmployeeServiceRecordCreateForm;
use App\Http\Requests\EmployeeServiceRecord\EmployeeServiceRecordEditForm;
use App\Models\Employee;
use App\Models\EmployeeServiceRecord;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceRecordController extends Controller
{
    public function __construct()
    {

    }


    public function index($employeeSlug, Request $request)
    {
        if(request()->has('draw')){

            $employee = Employee::findOrFail($employeeSlug);
            $sr = EmployeeServiceRecord::query()->where('employee_slug','=',$employee->slug);

            $rt = \Illuminate\Support\Facades\Request::route()->getName().'_destroy';

            return DataTables::of($sr)
                ->addColumn('action',function ($data) use ($rt){
                    return view('_hru.employee.service_records.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('salary',function ($data){
                    return number_format($data->salary,2);
                })
                ->editColumn('from_date',function ($data){
                    if($data->from_date != ''){
                        return Carbon::parse($data->from_date)->format('m/d/Y');
                    }
                })
                ->editColumn('to_date',function ($data){
                    if($data->upto_date == 1){
                        return 'TO DATE';
                    }
                    if($data->to_date != ''){
                        return Carbon::parse($data->to_date)->format('m/d/Y');
                    }
                })
                ->setRowId('slug')
                ->toJson();
        }

        if(request()->has('edit')){


            $slug = $employeeSlug;
            $sr = EmployeeServiceRecord::query()->where('slug','=',$slug)->first();
            if(empty($sr)){
                abort(503,'Service Record not found');
            }
            return view('_hru.employee.service_records.edit')->with(
                [
                    'sr' => $sr,
                ]
            );
        }
        if(request()->has('print')){
           return  $this->print($employeeSlug,$request);
        }
        $employee = Employee::findOrFail($employeeSlug);
        return view('_hru.employee.service_records.index')->with(['employee'=>$employee]);
    }

    public function print($employeeSlug,Request $request)
    {


        $employee =  Employee::query()
            ->with([
                'employeeServiceRecord' => function ($q) use($request) {
                    if($request->has('sort_by') && $request->sort_by != ''){
                        $q->orderBy('sequence_no',$request->sort_by);
                    }
                }
            ])
            ->findOrFail($employeeSlug);
        $srArr = [];

        if(!empty($employee->employeeServiceRecord)){
            foreach ($employee->employeeServiceRecord as $sr){
                array_push($srArr,$sr);
            }
        }

        //with new revision service-record-2015-03-12
        return view('printables.employee.service_record')->with([
            'employee' => $employee,
            'employee_service_records' => $srArr,
        ]);
    }
    public function store($employeeSlug,EmployeeServiceRecordCreateForm $request)
    {
        $sr = new EmployeeServiceRecord();
        $sr->slug = \Str::random();
        $sr->employee_slug = $employeeSlug;
        $sr->sequence_no = $request->sequence_no;
        $sr->from_date = $request->from_date;
        $sr->to_date = $request->to_date ?? null;
        $sr->position = $request->position;
        $sr->appointment_status = $request->appointment_status;
        $sr->salary = Helper::sanitizeAutonum($request->salary);
        $sr->mode_of_payment = $request->mode_of_payment;
        $sr->station = $request->station;
        $sr->gov_serve = $request->gov_serve;
        $sr->psc_serve = $request->psc_serve;
        $sr->lwp = $request->lwp;
        $sr->item_no = $request->item_no;
        $sr->salary_type = $request->salary_type;
        $sr->grade = $request->grade;
        $sr->step = $request->step;
        $sr->monthly_basic = $request->monthly_basic;
        $sr->due_to = $request->due_to;
        if($request->upto_date == true){
            $sr->upto_date = 1;
        }else{
            $sr->upto_date = 0;
        }
        $sr->spdate = $request->spdate;
        $sr->status = $request->status;
        $sr->remarks = $request->remarks;

        if($sr->save()){
            return $sr->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function update($slug,EmployeeServiceRecordEditForm $request)
    {

        $serviceRecord = EmployeeServiceRecord::findOrFail($slug);

        $serviceRecord->sequence_no = $request->sequence_no;
        $serviceRecord->from_date = $request->from_date;
        $serviceRecord->to_date = $request->to_date ?? null;
        $serviceRecord->position = $request->position;
        $serviceRecord->appointment_status = $request->appointment_status;
        $serviceRecord->salary = Helper::sanitizeAutonum($request->salary);
        $serviceRecord->mode_of_payment = $request->mode_of_payment;
        $serviceRecord->station = $request->station;
        $serviceRecord->gov_serve = $request->gov_serve;
        $serviceRecord->psc_serve = $request->psc_serve;
        $serviceRecord->lwp = $request->lwp;
        $serviceRecord->item_no = $request->item_no;
        $serviceRecord->salary_type = $request->salary_type;
        $serviceRecord->grade = $request->grade;
        $serviceRecord->step = $request->step;
        $serviceRecord->monthly_basic = $request->monthly_basic;
        $serviceRecord->due_to = $request->due_to;
        if($request->upto_date == true){
            $serviceRecord->upto_date = 1;
        }else{
            $serviceRecord->upto_date = 0;
        }
        $serviceRecord->spdate = $request->spdate;
        $serviceRecord->status = $request->status;
        $serviceRecord->remarks = $request->remarks;
        if($serviceRecord->save()){
            return $serviceRecord->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($slug)
    {
        $serviceRecord = EmployeeServiceRecord::findOrFail($slug);
        if($serviceRecord->delete()){
            return 1;
        }
        abort(503,'Error deleting item.');
    }
}