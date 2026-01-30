<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EducBGFormRequest;
use App\Models\Employee;
use App\Models\EmployeeEducationalBackground;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EducationController extends Controller
{
    public function index($slug,Request $request)
    {
        if($request->has('draw')){
            $educ = EmployeeEducationalBackground::query()
                ->where('employee_slug',$slug);
            return DataTables::of($educ)
                ->addColumn('action',function ($data){
                    return view('_hru.employee.education.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        if($request->has('edit')){
            return $this->edit($slug);
        }
        $employee = Employee::query()->findOrFail($slug);
        return view('_hru.employee.education.index')->with([
            'employee' => $employee,
        ]);
    }

    public function edit($slug)
    {
        $education = EmployeeEducationalBackground::query()->findOrFail($slug);
        return view('_hru.employee.education.edit')->with([
            'education' => $education,
        ]);
    }

    public function store($slug,EducBGFormRequest $request)
    {
        $eb = new EmployeeEducationalBackground;
        $eb->slug = Str::random();
        $eb->employee_slug = $slug;
        $eb->level = $request->level;
        $eb->priority = Arrays::educationalLevelsPriority()[$request->level] ?? null;
        $eb->school_name = $request->school_name;
        $eb->course = $request->course;
        $eb->date_from = $request->date_from;
        $eb->date_to = $request->date_to;
        $eb->units = $request->units;
        $eb->graduate_year = $request->graduate_year;
        $eb->scholarship = $request->scholarship;
        $eb->honor = $request->honor;
        if($eb->save()){
            return $eb->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function update($slug,Request $request)
    {
        $eb = EmployeeEducationalBackground::query()->findOrFail($slug);

        $eb->level = $request->level;
        $eb->priority = Arrays::educationalLevelsPriority()[$request->level] ?? null;
        $eb->school_name = $request->school_name;
        $eb->course = $request->course;
        $eb->date_from = $request->date_from;
        $eb->date_to = $request->date_to;
        $eb->units = $request->units;
        $eb->graduate_year = $request->graduate_year;
        $eb->scholarship = $request->scholarship;
        $eb->honor = $request->honor;
        if($eb->save()){
            return $eb->only('slug');
        }
        abort(503,'Error updating data.');
    }

    public function destroy($slug){
        $eb = EmployeeEducationalBackground::query()->findOrFail($slug);
        if($eb->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');
    }
}