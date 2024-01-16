<?php

namespace App\Http\Controllers;


use App\Models\DepartmentTree;
use App\Models\Employee;
use App\Models\HRPayPlanitilla;
use App\Models\HrPayPlantillaEmployees;
use App\Node;
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
            return DataTables::of($plantilla)
                ->editColumn('position',function($data){
                    return $data->position.'
                    <div class="table-subdetail" style="margin-top: 3px">
                    '.$data->department.($data->division != 'NONE' ? ' <i class="fa fa-chevron-right"></i> '.$data->division : '').($data->section != 'NONE' ? ' <i class="fa fa-chevron-right"></i> '.$data->section : '').'
                    </div>
                    ';
                })
                ->addColumn('action',function ($data){
                    $uri = route('dashboard.plantilla.show',$data->id);
                    $uri_edit = route('dashboard.plantilla.edit',$data->id);
                    $button = '<div class="btn-group">
                                    <button type="button" uri="'.$uri.'" class="btn btn-default btn-sm show_item_btn" data="'.$data->slug.'" data-toggle="modal" data-target ="#show_item_modal" title="View more" data-placement="left">
                                        <i class="fa fa-file-text"></i>
                                    </button>
                                    <button type="button" uri ="'.$uri_edit.'" data="'.$data->slug.'" class="btn btn-default btn-sm edit_item_btn" data-toggle="modal" data-target="#edit_item_modal" title="Edit" data-placement="top">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                          <li><a href="#" class="mark_as_vacant_btn" data="'.$data->id.'"><i class="fa icon-service-record"></i> Mark as Vacant</a></li>
                                        </ul>
                                    </div>
                                </div>';
                    return $button;
                })
                ->addColumn('orig_jg_si',function ($data){
                    return $data->original_job_grade.' - '.$data->original_job_grade_si;
                })
                ->addColumn('incumbent',function ($data){
                    if(!empty($data->incumbentEmployee)){
                        return '<b>'.($data->incumbentEmployee->lastname ?? '').', '.($data->incumbentEmployee->firstname ?? '').'</b>';
                    }
                    return  '<small class="text-muted">-</small>';
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
        return view('dashboard.plantilla.index');
    
    }

    


    public function create(){

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
        $pp = $this->find($id);
        return view('dashboard.plantilla.edit')->with([
            'pp' => $pp,
        ]);
        
    }




    public function update(PlantillaFormRequest $request, $id){
        $pp = $this->find($id);
        //$pp->item_no = $request->item_no;
        $pp->position = $request->position;
        $pp->original_job_grade = $request->original_job_grade;
        $pp->original_job_grade_si = $request->original_job_grade_si;
        $pp->employee_no = $request->employee_no;
        $pp->qs_education = $request->qs_education;
        $pp->qs_training = $request->qs_training;
        $pp->qs_experience = $request->qs_experience;
        $pp->qs_eligibility = $request->qs_eligibility;
        $pp->qs_competency = $request->qs_competency;
        $pp->place_of_assignment = $request->place_of_assignment;
        if($pp->update()){
            if(isset($pp->getChanges()['employee_no'])){
                $emp = Employee::query()->where('employee_no','=',$pp->employee_no)->first();
                $emp_appt_date = $emp->appointment_date;
                $emp_appt_date =  \Carbon::parse($emp_appt_date)->format('Y-m-d');
                $pp_e = HrPayPlantillaEmployees::query()->updateOrCreate(
                ['item_no' => $request->item_no, 'employee_no' => $pp->employee_no, 'appointment_date' => $emp_appt_date]
                );
            }
            return $pp->only('id');
        }


    }

    


    public function destroy($slug){

       return $this->plantilla->destroy($slug); 

    }

    public function print(){

        
        $pls = HRPayPlanitilla::query()
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
        return view('dashboard.plantilla.report');
    }

    public function reportGenerate(Request $request){

        $pls = HRPayPlanitilla::query()->with(['incumbentEmployee']);

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
        ]);
    }



    
}
