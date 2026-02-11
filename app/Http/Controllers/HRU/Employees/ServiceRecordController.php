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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
                    return  '';
                })
                ->editColumn('to_date',function ($data){
                    if($data->upto_date == 1){
                        return 'TO DATE';
                    }
                    if($data->to_date != ''){
                        return Carbon::parse($data->to_date)->format('m/d/Y');
                    }
                    return  '';
                })
                ->editColumn('monthly_basic',function ($data){
                    return view('_hru.employee.service_records.dtMonthlyBasic')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('position',function ($data){
                    return view('_hru.employee.service_records.dtPosition')->with([
                        'data' => $data,
                    ]);
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

        if(request()->has('showFile')){
            $slug = $employeeSlug;
            return  $this->showFile($slug);
        }

        if(request()->has('print')){
           return  $this->print($employeeSlug,$request);
        }
        $employee = Employee::findOrFail($employeeSlug);
        return view('_hru.employee.service_records.index')->with(['employee'=>$employee]);
    }

    public function print($employeeSlug,Request $request)
    {

        if($request->doc == 'NOSA'){
            return $this->printNosa($employeeSlug,$request);
        }
        if($request->doc == 'NOSI'){
            return $this->printNosi($employeeSlug,$request);
        }

        $employee =  Employee::query()
            ->with([
                'employeeServiceRecord' => function ($q) use($request) {
                    if($request->has('gov_serve') && $request->gov_serve != ''){
                        $q->where('gov_serve','=',$request->gov_serve);
                    }
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

    public function printNosa($slug,Request $request)
    {
        $selectedSr = EmployeeServiceRecord::query()
            ->findOrFail($slug);
        $srBeforeSelected = EmployeeServiceRecord::query()
            ->where('sequence_no','<',$selectedSr->sequence_no)
            ->where('employee_slug','=',$selectedSr->employee_slug)
            ->orderBy('sequence_no','desc')
            ->first();
        $employee = Employee::query()->findOrFail($selectedSr->employee_slug);
        $array = $employee->other_hr_actions_data ?? [];
        $array['nosa'] = [
            'old' => [
                'salary_type' => $srBeforeSelected->salary_type,
                'grade' => $srBeforeSelected->grade,
                'step' => $srBeforeSelected->step,
                'monthly_basic' => $srBeforeSelected->monthly_basic,
            ],
            'new' => [
                'salary_type' => $selectedSr->salary_type,
                'grade' => $selectedSr->grade,
                'step' => $selectedSr->step,
                'monthly_basic' => $selectedSr->monthly_basic,
            ],
//            'body' => 'Pursuant to CPCS Implementing Guidelines No. 2021-1 dated January 12, 2022, implementing Executive Order No. 150 s 2021, and Sugar Regulatory Administration Board Resolution No. 2023-157 dated September 26, 2023 duly approved by GCG on March 25, 2024, your salary is hereby adjusted effective '.Carbon::parse($selectedSr->from_date)->format('F d, Y').' as follows:',
            'body' => 'Pursuant to CPCS Implementing Guidelines No. 2025-01 dated October 22, 2025, implementing Executive Order No. 95 s. 2025, your salary is hereby adjusted effective  '.Carbon::parse($selectedSr->from_date)->format('F d, Y').' as follows:',

            'date_of_effectivity' => $selectedSr->from_date,
            'item_no' => $selectedSr->item_no,
            'position' => $selectedSr->position,
        ];
        $employee->other_hr_actions_data = $array;
        if($employee->save()){
            return redirect(route('dashboard.employee.other_hr_actions',$employee->slug).'?tab=nosa');
        }
    }
    public function printNosi($slug,Request $request)
    {
        $selectedSr = EmployeeServiceRecord::query()
            ->findOrFail($slug);
        $srBeforeSelected = EmployeeServiceRecord::query()
            ->where('sequence_no','<',$selectedSr->sequence_no)
            ->where('employee_slug','=',$selectedSr->employee_slug)
            ->orderBy('sequence_no','desc')
            ->first();
        $employee = Employee::query()->findOrFail($selectedSr->employee_slug);
        $array = $employee->other_hr_actions_data ?? [];
        $array['nosi'] = [
            'old' => [
                'salary_type' => $srBeforeSelected->salary_type,
                'grade' => $srBeforeSelected->grade,
                'step' => $srBeforeSelected->step,
                'monthly_basic' => $srBeforeSelected->monthly_basic,
            ],
            'new' => [
                'salary_type' => $selectedSr->salary_type,
                'grade' => $selectedSr->grade,
                'step' => $selectedSr->step,
                'monthly_basic' => $selectedSr->monthly_basic,
            ],
            'body' => 'Pursuant to CPCS Implementing Guidelines No. 2021-1 dated January 12, 2022, implementing Executive Order No. 150 s 2021, and implementing Item (5.2)(5.5.1) of the CPCS Implementing Guidelines, your salary as $position$ is hereby adjusted effective $effectivity$ as follows:',
            'date_of_effectivity' => $selectedSr->from_date,
            'item_no' => $selectedSr->item_no,
            'position' => $selectedSr->position,
        ];
        $employee->other_hr_actions_data = $array;
        if($employee->save()){
            return redirect(route('dashboard.employee.other_hr_actions',$employee->slug).'?tab=nosi');
        }
    }
    public function store($employeeSlug,EmployeeServiceRecordCreateForm $request)
    {
        if($request->has('update')){
            return  $this->update($employeeSlug,$request);
        }
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

    public function update($slug, EmployeeServiceRecordCreateForm $request)
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

        if(!empty($request->doc_file)){
            $storage = Storage::disk('service_records_attachments');
            if($request->is_file_changed == 1 && $serviceRecord->file_path != null){
                $oldFileName = $serviceRecord->file_path;
                $storage->delete($oldFileName);
            }
            $fileName = 'Service Record - '.Str::random().'.'.$request->file('doc_file')->getClientOriginalExtension();
            $store = $storage->putFileAs(null,$request->file('doc_file'),$fileName);
            $serviceRecord->file_path = $store;
        }
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

    public function showFile($slug)
    {
        $serviceRecord = EmployeeServiceRecord::findOrFail($slug);
        $storage = Storage::disk('service_records_attachments');
        if ($storage->exists($serviceRecord->file_path)){
            return  $storage->response($serviceRecord->file_path);
        }
        abort(404,'File does not exist.');
    }
}