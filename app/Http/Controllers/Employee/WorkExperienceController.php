<?php


namespace App\Http\Controllers\Employee;


use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeeController;
use App\Http\Requests\Employee\WorkExperienceFormRequest;
use App\Models\EmployeeExperience;
use App\Swep\Helpers\Helper;
use Dotenv\Util\Str;
use Illuminate\Support\Carbon;

class WorkExperienceController extends Controller
{
    public function dataTable($employee_slug){
        $works = EmployeeExperience::query()->where('employee_slug','=',$employee_slug);
        return \DataTables::of($works)
            ->addColumn('action',function($data){
                $destroy_route = "'".route("dashboard.employee.work.destroy","slug")."'";
                $slug = "'".$data->id."'";
                $button = '<div class="btn-group">
                                    <button data-toggle="modal" data-target="#edit_work_modal"  type="button" data="'.$data->id.'" class="btn btn-default btn-xs edit_work_btn"  title="Edit" data-placement="top">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" data="'.$data->id.'" onclick="delete_data('.$slug.','.$destroy_route.')" class="btn btn-xs btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>';
                return $button;
            })
            ->editColumn('date_from',function($data){
                return ($data->date_from != '') ? Carbon::parse($data->date_from)->format('M d, Y') : '';
            })
            ->editColumn('date_to',function($data){
                return ($data->date_to != '') ? Carbon::parse($data->date_to)->format('M d, Y') : '';
            })
            ->editColumn('salary',function($data){
                return number_format($data->salary,2);
            })
            ->editColumn('is_gov_service',function($data){
                if($data->is_gov_service == 1){
                    return '<i class="fa fa-check text-success"></i>';
                }
                return '<i class="fa fa-times text-danger"></i>';
            })
            ->escapeColumns([])
            ->setRowId('id')
            ->toJson();
    }

    public function create($employee_slug, EmployeeController $employeeController){
        $employee = $employeeController->findEmployeeBySlug($employee_slug);
        return view('dashboard.employee.credentials.work.create')->with([
            'employee' => $employee,
            'passed_rand' => request('rand'),
        ]);
    }

    public function store(WorkExperienceFormRequest $request){

        $work = new EmployeeExperience;
        $work->slug = \Illuminate\Support\Str::random();
        $work->employee_no = $request->employee_no;
        $work->employee_slug = $request->employee_slug;
        $work->date_from = $request->date_from;
        $work->date_to = $request->date_to;
        $work->position = $request->position;
        $work->company = $request->company;
        $work->salary = Helper::sanitizeAutonum($request->salary);
        $work->salary_grade = $request->salary_grade;
        $work->step = $request->step;
        $work->appointment_status = $request->appointment_status;
        $work->is_gov_service = $request->is_gov_service;
        if($work->save()){
            return $work->only('id');
        }
        abort(503,'Error saving data.');
    }

    private function findById($id){
        $work = EmployeeExperience::query()->find($id);
        if(!empty($work)){
            return $work;
        }
        abort(503,'Work Experience not found.');
    }
    public function edit($id){
        $work = $this->findById($id);
        return view('dashboard.employee.credentials.work.edit')->with([
            'work' => $work,
            'passed_rand' => request('rand'),
        ]);
    }

    public function update($id, WorkExperienceFormRequest $request){
        $work = $this->findById($id);
        $work->date_from = $request->date_from;
        $work->date_to = $request->date_to;
        $work->position = $request->position;
        $work->company = $request->company;
        $work->salary = Helper::sanitizeAutonum($request->salary);
        $work->salary_grade = $request->salary_grade;
        $work->step = $request->step;
        $work->appointment_status = $request->appointment_status;
        $work->is_gov_service = $request->is_gov_service;
        if($work->save()){
            return $work->only('id');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($id){
        $work = $this->findById($id);
        if($work->delete()){
            return 1;
        }
        abort(503, 'Error deleting item.');
    }
}