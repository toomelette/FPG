<?php


namespace App\Http\Controllers\Employee;


use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeeController;
use App\Http\Requests\Employee\EligibilityFormRequest;
use App\Models\EmployeeEligibility;
use Illuminate\Support\Carbon;

class EligibilityController extends Controller
{
    public function dataTable($employee_slug){

        $eligs = EmployeeEligibility::query()->where('employee_slug','=',$employee_slug);
        return \DataTables::of($eligs)
            ->addColumn('action',function($data){
                $destroy_route = "'".route("dashboard.employee.elig.destroy","slug")."'";
                $slug = "'".$data->id."'";
                $button = '<div class="btn-group">
                                    <button data-toggle="modal" data-target="#edit_elig_modal"  type="button" data="'.$data->id.'" class="btn btn-default btn-xs edit_elig_btn"  title="Edit" data-placement="top">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" data="'.$data->id.'" onclick="delete_data('.$slug.','.$destroy_route.')" class="btn btn-xs btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>';
                return $button;
            })
            ->editColumn('exam_date',function($data){
                return ($data->exam_date != '') ? Carbon::parse($data->exam_date)->format('M. d, Y') : '';
            })
            ->editColumn('license_validity',function($data){
                return ($data->license_validity != '') ? Carbon::parse($data->license_validity)->format('M. d, Y'): '';
            })
            ->escapeColumns([])
            ->setRowId('id')
            ->toJson();
    }

    public function create($employee_slug, EmployeeController $employeeController){
        $employee = $employeeController->findEmployeeBySlug($employee_slug);
        return view('dashboard.employee.credentials.eligibility.create')->with([
            'employee' => $employee,
            'passed_rand' => request('rand'),
        ]);
    }
    private  function findEmployeeBySlug($employee_slug, EmployeeController $employeeController){
        $employee = $employeeController->findEmployeeBySlug($employee_slug);
        return $employee_slug;
    }

    public function store(EligibilityFormRequest $request){

        $elig = new EmployeeEligibility;
        $elig->employee_slug = $request->employee_slug;
        $elig->employee_no = $request->employee_no;
        $elig->eligibility = $request->eligibility;
        $elig->level = $request->level;
        $elig->rating = $request->rating;
        $elig->exam_place = $request->exam_place;
        $elig->exam_date = $request->exam_date;
        $elig->license_no = $request->license_no;
        $elig->license_validity = $request->license_validity;
        if($elig->save()){
            return $elig->only('id');
        }
        abort(503,'Error saving data.');
    }
    private  function findById($id){
        $elig = EmployeeEligibility::query()->find($id);
        if(empty($elig)){
            abort(503, 'Eligibility not found.');
        }
        return $elig;
    }
    public function edit($id){
        $elig = $this->findById($id);
        return view('dashboard.employee.credentials.eligibility.edit')->with([
            'elig' => $elig,
            'passed_rand' => request('rand'),
        ]);
    }

    public function update($id, EligibilityFormRequest $request){
        $elig = $this->findById($id);
        $elig->eligibility = $request->eligibility;
        $elig->level = $request->level;
        $elig->rating = $request->rating;
        $elig->exam_place = $request->exam_place;
        $elig->exam_date = $request->exam_date;
        $elig->license_no = $request->license_no;
        $elig->license_validity = $request->license_validity;
        if($elig->update()){
            return $elig->only('id');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($id){
        $elig = $this->findById($id);
        if($elig->delete()){
            return 1;
        }
        abort('Error deleting data.');
    }
}