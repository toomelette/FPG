<?php


namespace App\Http\Controllers\Employee;


use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeeController;
use App\Http\Requests\Employee\EducBGFormRequest;
use App\Models\EmployeeEducationalBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EducationalBGController extends Controller
{
    public function create($employee_slug, EmployeeController $employeeController){

        $e = $employeeController->findEmployeeBySlug($employee_slug);
        return view('dashboard.employee.credentials.educ_bg.create')->with([
            'employee' => $e,
            'passed_rand' => request('rand'),
        ]);
    }

    public function dataTable($employee_slug){
        $educ_bg = EmployeeEducationalBackground::query()->where('employee_slug','=',$employee_slug);
        return \DataTables::of($educ_bg)
            ->addColumn('action',function($data){
                $destroy_route = "'".route("dashboard.employee.educ_bg.destroy","slug")."'";
                $slug = "'".$data->id."'";
                $button = '<div class="btn-group">
                                    <button data-toggle="modal" data-target="#edit_educ_bg_modal"  type="button" data="'.$data->id.'" class="btn btn-default btn-xs edit_educ_bg_btn"  title="Edit" data-placement="top">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" data="'.$data->id.'" onclick="delete_data('.$slug.','.$destroy_route.')" class="btn btn-xs btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>';
                return $button;
            })
            ->escapeColumns([])
            ->setRowId('id')
            ->toJson();
    }

    public function edit($id){
        $ebg = $this->findById($id);
        return view('dashboard.employee.credentials.educ_bg.edit')->with([
            'ebg' => $ebg,
            'passed_rand' => request('rand'),
        ]);
    }
    public function update($id,EducBGFormRequest $request){

        $eb = $this->findById($id);
        $eb->level = $request->level;
        $eb->school_name = $request->school_name;
        $eb->course = $request->course;
        $eb->date_from = $request->date_from;
        $eb->date_to = $request->date_to;
        $eb->units = $request->units;
        $eb->graduate_year = $request->graduate_year;
        $eb->scholarship = $request->scholarship;
        $eb->honor = $request->honor;
        if($eb->update()){

            return $eb->only('id');
        }
    }

    public function findById($id){
        $ebg = EmployeeEducationalBackground::query()->find($id);
        if(empty($ebg)){
            abort(503,'Educational Background not found');
        }
        return $ebg;
    }

    public function store(EducBGFormRequest $request){

        $eb = new EmployeeEducationalBackground;
        $eb->slug = Str::random();
        $eb->employee_slug = $request->employee_slug;
        $eb->employee_no = $request->employee_no;
        $eb->level = $request->level;
        $eb->school_name = $request->school_name;
        $eb->course = $request->course;
        $eb->date_from = $request->date_from;
        $eb->date_to = $request->date_to;
        $eb->units = $request->units;
        $eb->graduate_year = $request->graduate_year;
        $eb->scholarship = $request->scholarship;
        $eb->honor = $request->honor;
        if($eb->save()){
            return $eb->only('id');
        }
    }

    public function destroy($id){
        $ebg = $this->findById($id);
        if($ebg->delete()){
            return 1;
        }
    }
}