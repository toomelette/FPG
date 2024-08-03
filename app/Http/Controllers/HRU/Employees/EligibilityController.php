<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EligibilityFormRequest;
use App\Models\EmployeeEligibility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class EligibilityController extends Controller
{
    public function index($slug,Request $request)
    {
        if($request->has('draw')){
            $eligibilities = EmployeeEligibility::query()
                ->where('employee_slug','=',$slug);
            return DataTables::of($eligibilities)
                ->addColumn('action',function($data){
                    return view('_hru.employee.eligibility.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        if($request->has('edit')){
            return  $this->edit($slug);
        }
    }

    public function edit($slug)
    {
        $elig = EmployeeEligibility::query()->findOrFail($slug);
        return view('_hru.employee.eligibility.edit')->with([
            'eligibility' => $elig,
        ]);
    }
    public function store($slug,EligibilityFormRequest $request)
    {
        $elig = new EmployeeEligibility;
        $elig->slug = Str::random();
        $elig->employee_slug = $slug;
        $elig->eligibility = $request->eligibility;
        $elig->level = $request->level;
        $elig->rating = $request->rating;
        $elig->exam_place = $request->exam_place;
        $elig->exam_date = $request->exam_date;
        $elig->license_no = $request->license_no;
        $elig->license_validity = $request->license_validity;
        if($elig->save()){
            return $elig->only('slug');
        }
        abort(503,'Error saving data.');
    }
    public function update($slug,EligibilityFormRequest $request)
    {
        $elig = EmployeeEligibility::query()->findOrFail($slug);
        $elig->eligibility = $request->eligibility;
        $elig->level = $request->level;
        $elig->rating = $request->rating;
        $elig->exam_place = $request->exam_place;
        $elig->exam_date = $request->exam_date;
        $elig->license_no = $request->license_no;
        $elig->license_validity = $request->license_validity;
        if($elig->update()){
            return $elig->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($slug){
        $elig = EmployeeEligibility::query()->findOrFail($slug);
        if($elig->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');
    }
}