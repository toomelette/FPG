<?php

namespace App\Http\Controllers;


use App\Models\DepartmentTree;
use App\Models\Employee;
use App\Models\HRPayPlanitilla;
use App\Models\HrPayPlantillaEmployees;
use App\Models\HRU\HrPlantillaClassification;
use App\Node;
use App\Swep\Helpers\Arrays;
use App\Swep\Services\PlantillaService;
use App\Http\Requests\Plantilla\PlantillaFormRequest;
use App\Http\Requests\Plantilla\PlantillaFilterRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class PlantillaController extends Controller{



	protected $plantilla;



    public function __construct(PlantillaService $plantilla){

        $this->plantilla = $plantilla;

    }



    
    public function index(Request $request){
        if(request()->ajax() && $request->has('draw')){
            $plantilla = HRPayPlanitilla::query()->with('incumbentEmployee');
            $jobGrades = Arrays::jobGrades();
            return DataTables::of($plantilla)
                ->editColumn('position',function($data){
                    return view('_hru.plantilla.dtPosition')->with([
                        'data'=> $data,
                    ]);
                })
                ->addColumn('action',function ($data){
                    return view('_hru.plantilla.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('orig_jg_si',function ($data){
                    return $data->job_grade.' - '.$data->step_inc;
                })
                ->addColumn('incumbent',function ($data) use ($jobGrades){;
                    return view('_hru.plantilla.dtIncumbent')->with([
                        'data' => $data,
                        'jobGrades' => $jobGrades,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('id')
                ->make(true);
        }

        if($request->has('mark_as_vacant') && $request->mark_as_vacant == 'true'){
            $plantilla = HRPayPlanitilla::query()->find($request->id);
            if(!empty($plantilla)){
                $plantilla->employee_no = null;
                $plantilla->employee_name = null;
                if($plantilla->update()){
                    return 1;
                }
            }
            abort(503,'Error updating item.');
        }
        return view('_hru.plantilla.index');
    
    }

    


    public function create(){
        return redirect(route('dashboard.plantilla.index'));
        return view('dashboard.plantilla.create');

    }

    public function show($id){


        $pp = HRPayPlanitilla::query()->with(['occupants'])->find($id);
        return view('dashboard.plantilla.show')->with([
            'pp' => $pp,
        ]);
    }


    public function store(PlantillaFormRequest $request){

        return $this->plantilla->store($request);
        
    }


    private function find($id){
        $pp = HRPayPlanitilla::query()->find($id);
        if(!empty($pp)){
            return $pp;
        }
        abort(503,'Pay Plantilla not found');
    }

    private function typeAhead(Request $request){
        $all_employees = Employee::query()->where('is_active' ,'=','ACTIVE')->get();
        $list = [];
        if(!empty($all_employees)){
            foreach ($all_employees as $employee){
                $to_push = [
                    'id'=> $employee->employee_no ,
                    'name' => strtoupper($employee->lastname.', '.$employee->firstname),
                ];
                array_push($list,$to_push);
            }
        }
        return $list;
    }

    public function edit($id){
        if(request('typeahead') == true){
            return $this->typeAhead(request());
        }
        $plantilla = $this->find($id);
        return view('_hru.plantilla.edit')->with([
            'plantilla' => $plantilla,
        ]);
        
    }




    public function update(PlantillaFormRequest $request, $id){

        $pp = $this->find($id);
        $pp->position = $request->position;
        $pp->job_grade = $request->job_grade;
        $pp->step_inc = $request->step_inc;
        $pp->employee_no = $request->employee_no;
        $pp->actual_salary = Arrays::jobGrades()[$request->job_grade][$request->step_inc] ?? 0;
        $pp->actual_salary_gcg = Arrays::jobGrades()[$request->job_grade][$request->step_inc] ?? 0;
        $pp->qs_education = $request->qs_education;
        $pp->qs_training = $request->qs_training;
        $pp->qs_experience = $request->qs_experience;
        $pp->qs_eligibility = $request->qs_eligibility;
        $pp->qs_competency = $request->qs_competency;
        $pp->place_of_assignment = $request->place_of_assignment;
        $classToInsert = [];
        if($request->has('job_classification') && count($request->job_classification) > 0){
            foreach ($request->job_classification as $jobClass) {
                $classToInsert[] = [
                    'item_no' => $pp->item_no,
                    'classification' => $jobClass,
                ];

            }
        }
        if($pp->update()){
            $pp->classifications()->delete();
            HrPlantillaClassification::query()->insert($classToInsert);
            return $pp->only('id');
        }
        abort(503,'Error saving data.');
    }

    


    public function destroy($slug){

       return $this->plantilla->destroy($slug); 

    }

    public function print(){

        
        $pls = HRPayPlanitilla::query()
            ->with(['incumbentEmployee.employeeEducationalBackground'])
            ->orderBy('control_no','asc')
            ->orderBy('department_header','asc')
            ->orderBy('division_header','asc')
            ->orderBy('section_header','asc')
            ->orderBy('item_no','asc')
            ->get();
        $plsArr = [];
        foreach ($pls as $pl){
            if($pl->section == 'NONE' && $pl->division== 'NONE'){
                $plsArr[$pl->department][$pl->item_no]= $pl;
            }elseif($pl->division != 'NONE' && $pl->section == 'NONE'){
                $plsArr[$pl->department][$pl->division][$pl->item_no] = $pl;
            }else{
                $plsArr[$pl->department][$pl->division][$pl->section][$pl->item_no] = $pl;
            }

        }
//        dd($plsArr) ;
        return view('printables.plantilla.print')->with([
            'pls' => $plsArr,

        ]);
    }

    public function report(){
        return view('_hru.plantilla.report');
    }

    public function reportGenerate(Request $request){

        $pls = HRPayPlanitilla::query()->with([
            'incumbentEmployee.employeeEducationalBackground',
            'incumbentEmployee.employeeEligibility',
        ]);

        if($request->has('order_column') && $request->order_column != null){
            $pls = $pls->orderBy($request->order_column,$request->direction ?? 'asc');
        }
        $pls = $pls
            ->orderBy('control_no','asc')
            ->orderBy('department_header','asc')
            ->orderBy('division_header','asc')
            ->orderBy('section_header','asc')
            ->orderBy('item_no','asc')
            ->get();
        $plsArr = [];
        foreach ($pls as $pl){
            if($pl->section == 'NONE' && $pl->division== 'NONE'){
                if($request->has('type') && $request->type == 'department'){
                    $plsArr[$pl->department][$pl->department][$pl->item_no]= $pl;
                }elseif($request->has('type') && $request->type == 'job_grade'){
                    $plsArr[$pl->job_grade][$pl->department][$pl->item_no]= $pl;
                }elseif($request->has('type') && $request->type == 'location'){
                    $plsArr[$pl->location][$pl->department][$pl->item_no]= $pl;
                }else{
                    $plsArr['ALL'][$pl->department][$pl->item_no]= $pl;
                }
            }elseif($pl->division != 'NONE' && $pl->section == 'NONE'){
                if($request->has('type') && $request->type == 'department'){
                    $plsArr[$pl->department][$pl->department][$pl->division][$pl->item_no] = $pl;
                }elseif($request->has('type') && $request->type == 'job_grade'){
                    $plsArr[$pl->job_grade][$pl->department][$pl->division][$pl->item_no] = $pl;
                }elseif($request->has('type') && $request->type == 'location'){
                    $plsArr[$pl->location][$pl->department][$pl->division][$pl->item_no] = $pl;
                }else{
                    $plsArr['ALL'][$pl->department][$pl->division][$pl->item_no] = $pl;
                }
            }else{
                if($request->has('type') && $request->type == 'department'){
                    $plsArr[$pl->department][$pl->department][$pl->division][$pl->section][$pl->item_no] = $pl;
                }elseif($request->has('type') && $request->type == 'job_grade'){
                    $plsArr[$pl->job_grade][$pl->department][$pl->division][$pl->section][$pl->item_no] = $pl;
                }elseif($request->has('type') && $request->type == 'location'){
                    $plsArr[$pl->location][$pl->department][$pl->division][$pl->section][$pl->item_no] = $pl;
                }else{
                    $plsArr['ALL'][$pl->department][$pl->division][$pl->section][$pl->item_no] = $pl;
                }
            }

        }
        ksort($plsArr);
        return view('printables.plantilla.print')->with([
            'planitillaArray' => $plsArr,
            'columns' => $request->columns,
            'request' => $request,
            'jobGrades' => \App\Swep\Helpers\Arrays::jobGrades(),
        ]);
    }



    
}
