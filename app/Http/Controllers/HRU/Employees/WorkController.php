<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\WorkExperienceFormRequest;
use App\Models\EmployeeExperience;
use App\Models\QC\Employee;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class WorkController extends Controller
{
    public function index($slug, Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $works = EmployeeExperience::query()
                ->where('employee_slug','=',$slug);
            return DataTables::of($works)
                ->addColumn('action',function($data){
                    return view('_hru.employee.work.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('date_from',function($data){
                    return Helper::dateFormat($data->date_from,'m/d/Y');
                })
                ->editColumn('date_to',function($data){
                    return Helper::dateFormat($data->date_to,'m/d/Y');
                })
                ->editColumn('salary',function($data){
                    return Helper::toNumber($data->salary);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }

        if($request->has('edit')){
            return $this->edit($slug);
        }
    }
    public function edit($slug)
    {
        $work = EmployeeExperience::query()->findOrFail($slug);
        return view('_hru.employee.work.edit')->with([
            'work' => $work,
        ]);
    }

    public function store($employeeSlug, WorkExperienceFormRequest $request)
    {
        $work = new EmployeeExperience();
        $work->slug = Str::random();
        $work->employee_slug = $employeeSlug;
        $work->date_from = $request->date_from;
        $work->date_to = $request->date_to;
        $work->position = $request->position;
        $work->company = $request->company;
        $work->salary = Helper::sanitizeAutonum($request->salary);
        $work->salary_grade = $request->salary_grade;
        $work->step = $request->step;
        $work->appointment_status = $request->appointment_status;
        $work->is_gov_service = $request->is_gov_service == 0 ? null : 1;
        if($work->save()){
            return $work->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function update($workSlug,WorkExperienceFormRequest $request)
    {
        $work = EmployeeExperience::query()->findOrFail($workSlug);
        $work->date_from = $request->date_from;
        $work->date_to = $request->date_to;
        $work->position = $request->position;
        $work->company = $request->company;
        $work->salary = Helper::sanitizeAutonum($request->salary);
        $work->salary_grade = $request->salary_grade;
        $work->step = $request->step;
        $work->appointment_status = $request->appointment_status;
        $work->is_gov_service = $request->is_gov_service == 0 ? null : 1;
        if($work->save()){
            return $work->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($workSlug)
    {
        $work = EmployeeExperience::query()->findOrFail($workSlug);
        if($work->delete()){
            return 1;
        }
        abort(503,'Error deleting item.');
    }
}