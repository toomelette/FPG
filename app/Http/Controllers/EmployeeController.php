<?php

namespace App\Http\Controllers;


use App\Http\Requests\Employee\BiometricUserIdFormRequest;
use App\Models\Employee;
use App\Models\EmployeeServiceRecord;
use App\Models\EmployeeTraining;
use App\Models\HRU\HrOtherActions;
use App\Models\SuSettings;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use App\Swep\Services\EmployeeService;
use App\Swep\Services\EmployeeTrainingService;
use App\Swep\Services\EmployeeServiceRecordService;
use App\Swep\Services\EmployeeMatrixService;

use App\Http\Requests\Employee\EmployeeFormRequest;
use App\Http\Requests\Employee\EmployeeFilterRequest;
use App\Http\Requests\Employee\EmployeeReportRequest;

use App\Http\Requests\EmployeeServiceRecord\EmployeeServiceRecordCreateForm;
use App\Http\Requests\EmployeeServiceRecord\EmployeeServiceRecordEditForm;

use App\Http\Requests\EmployeeTraining\EmployeeTrainingCreateForm;
use App\Http\Requests\EmployeeTraining\EmployeeTrainingEditForm;
use App\Http\Requests\EmployeeTraining\EmployeeTrainingPrintFilterForm;

use App\Http\Requests\EmployeeMatrix\EmployeeMatrixFormRequest;
use App\Http\Requests\EmployeeMatrix\EmployeeMatrixPrintRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;
use function Ramsey\Uuid\v1;


class EmployeeController extends Controller{



    protected $employee;
    protected $employee_sr;
    protected $employee_trng;
    protected $employee_matrix;



    public function __construct(EmployeeService $employee, EmployeeServiceRecordService $employee_sr, EmployeeTrainingService $employee_trng, EmployeeMatrixService $employee_matrix){

        $this->employee = $employee;
        $this->employee_sr = $employee_sr;
        $this->employee_trng = $employee_trng;
        $this->employee_matrix = $employee_matrix;

    }




    // Employee Master
	public function index(Request $request){

        if($request->ajax() && $request->has('draw')){
            return $this->dataTable($request);
        }
        return view('_hru.employee.index');
    
    }

    public function indexCos(Request $request){
        if($request->ajax() && $request->has('draw')){
            return $this->dataTable($request,'COS');
        }
        return view('_hru.employee.index');
    }

    private function dataTable($request, $type = 'PERMANENT'){
        $sql_server_is_on = Helper::sqlServerIsOn();
        $cols = ['fullname','employee_no','position','email','biometric_user_id', 'date_of_birth','sex','civil_status','firstname','slug','name_ext','cell_no','photo'];
        $employees = Employee::query()->with([
            'responsibilityCenter',
        ]);

        if($type == 'PERMANENT'){
            $employees = $employees->permanent();
        }else{
            $employees = $employees->cos();
        }
        if($sql_server_is_on === true){
            $employees = $employees->with('empMaster');
        }

        if($request->draw == 1){
            $employees = $employees->where('is_active','=','ACTIVE');
        }
        if($request->has('is_active') && $request->is_active != ''){
            $employees = $employees->where('is_active','=',$request->is_active);
        }

        if($request->has('sex') && $request->sex != ''){
            $employees = $employees->where('sex','=',$request->sex);
        }
        if($request->has('locations') && $request->locations != ''){
            $employees = $employees->where('locations','=',$request->locations);
        }
        if($request->has('assignment') && $request->assignment != null){
            $employees = $employees->where('assignment','=',$request->assignment);
        }

        if($request->has('resp_center') && $request->resp_center != null){
            $employees = $employees->where('resp_center','=',$request->resp_center);
        }

        $jobGrades = Arrays::jobGrades();
        return DataTables::of($employees)
            ->addColumn('action', function ($data){
                $destroy_route = "'".route("dashboard.employee.destroy","slug")."'";
                $slug = "'".$data->slug."'";
                $button = '<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm view_employee_btn" data="'.$data->slug.'" data-toggle="modal" data-target ="#show_employee_modal" title="View more" data-placement="left">
                                        <i class="fa fa-file-text"></i>
                                    </button>
                                   
                                    <a  href="'. route('dashboard.employee.edit', $data->slug).'" for="linkToEdit" type="button" data="'.$data->slug.'" class="btn btn-default btn-sm edit_jo_employee_btn"  title="Edit" data-placement="top">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" data="'.$data->slug.'" onclick="delete_data('.$slug.','.$destroy_route.')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                   <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                          <li><a href="#" data-toggle="modal" data-target="#service_records_modal" class="service_records_btn" data="'.$data->slug.'"><i class="fa icon-service-record"></i> Service Records</a></li>
                                          <li><a href="#" data-toggle="modal" data-target="#trainings_modal" class="trainings_btn" data="'.$data->slug.'"><i class="fa icon-seminar"></i> Trainings</a></li>
                                          <li><a href="#" data-toggle="modal" data-target="#credentials_modal" class="credentials_btn" data="'.$data->slug.'"><i class="fa swep-certificate"></i> Credentials</a></li>
                                          <li><a href="#" data-toggle="modal" data-target="#matrix_modal" class="matrix_btn" data="'.$data->slug.'"><i class="fa fa-dashboard"></i> Matrix</a></li>
                                          <li><a href="#" uri="'.route('dashboard.file201.index').'"  data-toggle="modal" data-target="#file201_modal" class="file201_btn" data="'.$data->slug.'"><i class="fa fa-folder"></i> 201 File</a></li>
                                          <li><a href="#"  employee="'.$data->lastname.', '.$data->firstname.'" class="bm_uid_btn" data="'.$data->slug.'" bm_uid="'.$data->biometric_user_id.'"><i class="fa icon-ico-fingerprint"></i> Biometric User ID</a></li>
                                            <li><a href="#" data-toggle="modal" data-target="#other_hr_actions_modal" class="other_actions_btn" data="'.$data->slug.'"><i class="fa icon-service-record"></i> Other HR Actions</a></li>
                                            <li><a target="_blank" href="'.route('dashboard.employee.generate_qr',$data->slug).'" class="other_actions_btn" data="'.$data->slug.'"><i class="fa fa-qrcode"></i> Get QR Code</a></li>
                                        </ul>
                                    </div>
                                </div>';

                return view('_hru.employee.dt.buttons')->with([
                    'data' => $data,
                ]);
                return $button;
            })->editColumn('biometric_user_id',function ($data){
                if($data->biometric_user_id == 0){
                    return 'N/A';
                }
                return $data->biometric_user_id;
            })->editColumn('position',function ($data) use($jobGrades){
                return view('_hru.employee.dt.position')->with([
                    'data' => $data,
                    'jobGrades' => $jobGrades,
                ]);
            })
            ->editColumn('employee_no',function($data){
                return view('_hru.employee.dt.employment_details')->with([
                    'data' => $data,
                ]);
            })
            ->addColumn('photo',function($data){
                return view('_hru.employee.dt.photo')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('fullname',function ($data){

                return view('_hru.employee.dt.fullname')->with([
                    'data' => $data,
                ]);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }
    


    public function create(){

        return view('_hru.employee.create');

    }

    


    public function store(EmployeeFormRequest $request){
//        return  $request;
    	return $this->employee->store($request);
        
    }




    public function show($slug){

        $employee = Employee::query()
            ->with('employeeAddress',
                'employeeFamilyDetail',
                'employeeOtherQuestion',
                'employeeTraining',
                'employeeChildren',
                'employeeEducationalBackground',
                'employeeEligibility',
                'employeeExperience',
                'employeeOrganization',
                'employeeRecognition',
                'employeeReference',
                'employeeSpecialSkill',
                'employeeVoluntaryWork',
                'employeeServiceRecord',
                'employeeMatrix',
                'permissionSlip',
            )
            ->findOrFail($slug);
        return view('_hru.employee.show')->with([
            'employee' => $employee,
            'decolor' => true,
        ]);
    }




    public function edit($slug){
        $employee = Employee::query()->findOrFail($slug);
        return view('_hru.employee.edit')->with([
            'employee' => $employee,
        ]);
    	return $this->employee->edit($slug);
        
    }




    public function update(EmployeeFormRequest $request, $slug){
        return $this->employee->update($request, $slug);
    }

    


    public function destroy($slug){

    	$employee = $this->employee->destroy($slug);
        if($employee){
            return 1;
        }
        abort(503,'Error deleting data');
    }




    public function printPDS($slug, $page){

        return $this->employee->printPDS($slug, $page);

    }

    public function findEmployeeBySlug($slug){
        $employee = Employee::query()->where('slug','=',$slug)->first();
        if(empty($employee)){
            abort(503,'Employee not found.');
        }
        return $employee;
    }


    // Service Record
    public function serviceRecord($slug){


    }




    public function serviceRecordStore(EmployeeServiceRecordCreateForm $request, $slug){
        $sr = $this->employee_sr->store($request, $slug);
        if($sr){
            return $sr->only('slug');
        }
        abort(503, 'Error saving data.');
    }




    public function serviceRecordUpdate(EmployeeServiceRecordCreateForm $request, $slug){
        //slug is for sr
        $sr = $this->employee_sr->update($request, $slug);
        if($sr){
            return $sr->only('slug');
        }

        abort(503, 'Error saving data.');
    }




    public function serviceRecordDestroy($slug){
        $sr = $this->employee_sr->destroy($slug);
        if($sr){
            return 1;
        }
        abort(503,'Error deleting data.');
    }




    public function serviceRecordPrint($slug){
        $employee =  $this->findEmployeeBySlug($slug);
        $srArr = [];

        if(!empty($employee->employeeServiceRecord)){
            foreach ($employee->employeeServiceRecord as $sr){
                array_push($srArr,$sr);
            }
        }

        return view('printables.employee.service_record')->with([
            'employee' => $employee,
            'employee_service_records' => $srArr,
        ]);
    }



    // Trainings
    public function training($slug){

        if(request()->ajax() && request()->has('draw')){
            $employee = $this->findEmployeeBySlug($slug);
            $trainings = EmployeeTraining::query()->where('employee_slug','=',$employee->slug);

            return DataTables::of($trainings)
                ->addColumn('action',function ($data){
                    $destroy_route = "'".route(\Illuminate\Support\Facades\Request::route()->getName()."_destroy","slug")."'";
                    $slug = "'".$data->slug."'";

                    return '<div class="btn-group btn-group-xs" role="toolbar" aria-label="...">
                                <button type="button" class="btn btn-default edit_training_btn" data-toggle="modal" data-target="#edit_training_modal" data="'.$data->slug.'"><i class="fa fa-edit"></i></button>
                                <button data="'.$data->slug.'" type="button" onclick="delete_data('.$slug.','.$destroy_route.')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </div>';
                })->editColumn('date_to',function ($data){
                    return ($data->date_to != '' ? Carbon::parse($data->date_to)->format('m/d/Y') : '');
                })
                ->editColumn('date_from',function ($data){
                    return ($data->date_from != '' ? Carbon::parse($data->date_from)->format('m/d/Y') : '');
                })
                ->setRowId('slug')
                ->toJson();
        }

        if(request()->ajax() && request()->has('add')){
            $employee = $this->findEmployeeBySlug($slug);
            return view('dashboard.employee.create_training')->with([
                'employee' => $employee,
            ]);
        }

        if(request()->ajax() && request()->has('edit')){
            $employee = $this->findEmployeeBySlug($slug);
            $training = EmployeeTraining::query()->where('slug','=',\request('training'))->first();
            if(empty($training)){
                abort(503, 'Training not found');
            }
            return view('dashboard.employee.edit_training')->with([
                'employee' => $employee,
                'training' => $training,
            ]);
        }
        $employee = $this->findEmployeeBySlug($slug);
        return view('dashboard.employee.training')->with([
            'employee' => $employee,
        ]);
        return $this->employee_trng->index($slug);

    }




    public function trainingStore(EmployeeTrainingCreateForm $request, $slug){

        $emp_trng = $this->employee_trng->store($request, $slug);
        if($emp_trng){
            return $emp_trng->only('slug');
        }

        abort(503,'Error saving data.');
    }




    public function trainingUpdate(EmployeeTrainingCreateForm $request, $slug){
        //slug is for training
        $emp_trng = $this->employee_trng->update($request, $slug);
        if($emp_trng){
            return $emp_trng->only('slug');
        }
        abort(503, 'Error updating data.');
    }




    public function trainingDestroy($slug){

        $emp_trng = $this->employee_trng->destroy($slug);
        if($emp_trng){
            return 1;
        }
        abort(503,'Error deleting data.');
    }




    public function trainingPrint(EmployeeTrainingPrintFilterForm $request, $slug){

        $emp = $this->findEmployeeBySlug($slug);
        $trainingsArray = [];
        $itemsPerPage = $request->items_per_sheet ?? 15;
        $allCount = $emp->employeeTraining()->count() ?? 0;
        $counter = 0;
        $arrayCounter = 0;
        $employeeTraining = $emp->employeeTraining();
        if(!empty($request->df)){
            $employeeTraining = $employeeTraining->where('date_from','>=',$request->df);
        }
        if(!empty($request->dt)){
            $employeeTraining =  $employeeTraining->where('date_to','<=',$request->dt);
        }

         $employeeTraining=$employeeTraining
             ->orderBy('sequence_no','desc')
             ->get();
        foreach ($employeeTraining as $training){
            if($counter < $itemsPerPage){
                $trainingsArray[$arrayCounter][$training->slug] = $training;
            }else{
                $arrayCounter++;
                $trainingsArray[$arrayCounter][$training->slug] = $training;
                $counter = 0;
            }
            $counter++;
        }


        return \view('printables.employee.trainings')->with([
            'employee' => $emp,
            'trainingsArray' => $trainingsArray,
        ]);


    }



    // Matrix
    public function matrix($slug){
        $employee = $this->findEmployeeBySlug($slug);
        return view('dashboard.employee.edit_matrix')->with([
           'employee'=>$employee,
        ]);

    }




    public function matrixUpdate(EmployeeMatrixFormRequest $request, $slug){
        $employee = $this->findEmployeeBySlug($slug);
        $emp_matrix = $this->employee_matrix->update($request, $slug);
        if($emp_matrix){

            $view = View::make('dashboard.employee.matrix_show')->with([
                'employee' => $employee,
                'col' => 2,
            ]);
            $sections = $view->renderSections();
            $modal_body = $sections['modal-body'];
            return $modal_body;
        }
        abort(503,'Error saving data.');
    }




    public function matrixShow($slug){
        $employee = $this->findEmployeeBySlug($slug);
        return view('dashboard.employee.matrix_show')->with([
            'employee' => $employee,
        ]);
        return $this->employee_matrix->show($slug);

    }




    public function matrixPrint(EmployeeMatrixPrintRequest $request, $slug){
        
        return $this->employee_matrix->print($request, $slug);

    }




    public function report(){
        $allColumnsForReport = $this->allColumnsForReport();
        return view('_hru.employee.report')->with([
            'allColumnsForReport' => $allColumnsForReport,
        ]);
    }





    public function edit_bm_uid(Request $request){

        $employee = $employee = Employee::query();
        if(Helper::sqlServerIsOn() === true){
            $employee = $employee->with('empMaster');
        }
        $employee = $employee->where('slug','=', $request->slug)->first();
        if(!empty($employee)){
            return view('dashboard.employee.edit_bm_uid')->with([
                'employee' => $employee,
            ]);
        }
    }

    public function update_bm_uid(BiometricUserIdFormRequest $request){

        $employee = $this->findEmployeeBySlug($request->employee);

        if(!empty($employee)){
            $employee->biometric_user_id = $request->biometric_user_id;
            if($employee->update()){
                return $employee->only('slug','employee_no');
            }
            abort(503,'Error Saving');
        }
        abort(503,'Data not found');
    }

    public function reportGenerate(EmployeeReportRequest $request){

        $employees = Employee::query()
            ->with([
//                'employeeTraining',
//                'employeeServiceRecord',
//                'employeeEducationalBackground',
//                'employeeEligibility',
//                'employeeChildren',
                'responsibilityCenter.description',
            ])
        ;
        $filters = [];

        if($request->status != null){
            $employees = $employees->where('is_active','=',$request->status);
            array_push($filters,'STATUS: '.$request->status);
        }
        if($request->locations != null){
            if(count($request->locations) > 0){
                $locations = $request->locations;
                $push = 'LOCATION: ';
                $employees = $employees->where(function ($query) use ($locations, &$push){
                    foreach ($locations as $location){
                       $query = $query->orWhere('locations','=',$location);
                        $push = $push.' '.$location.', ';
                    }
                });
                array_push($filters,$push);
            }
        }

        if($request->civil_status != null){
            if(count($request->civil_status) > 0){
                $civil_statuses = $request->civil_status;
                $push = 'CIVIL STAT: ';
                $employees = $employees->where(function ($query) use ($civil_statuses, &$push){
                    foreach ($civil_statuses as $civil_status){
                        $query = $query->orWhere('civil_status','=',$civil_status);
                        $push = $push.' '.$civil_status.', ';
                    }
                });
                array_push($filters,$push);
            }
        }

        if($request->sex != null){
            $employees = $employees->where('sex','=',$request->sex);
            array_push($filters,'SEX: '.$request->sex);
        }
        if($request->order_column != null){
            if($request->direction == null){
                abort(501,'Missing parameter(s). <b class="text-danger">DIRECTION</b> field is required if Column field has value.');
            }
            $employees = $employees->orderBy($request->order_column,$request->direction);
        }
        $employees = $employees->orderBy('lastname','asc');
        $employees = $employees->get();
        $employee_arr = [];
        $type = null;

        switch ($request->type){
            case 'unit':
                $type = 'department_unit_id';
                break;
            case 'address':
                $type = 'employeeAddress';
                break;
            default:
                $type = $request->type;
                break;
        }


        $selected_columns = $request->columns;
        foreach ($employees as $employee){
            $t = $employee->$type;
            if($type == 'employeeAddress'){
                if(!empty($employee->employeeAddress)){
                    $t = $employee->employeeAddress->res_address_city;
                }
            }
            if($type == 'department_unit_id'){
                if(!empty($employee->departmentUnit)){
                    $t = $employee->departmentUnit->description;
                }
            }
            $employee_arr[$t][$employee->employee_no] = $employee;
        }

        if(count($employee_arr) < 1){
            abort(505,'Try different filter criteria.');
        }
        ksort($employee_arr);
        return view('printables.employee.report')->with([
            'employees' => $employee_arr,
            'selected_columns' => $selected_columns,
            'all_columns' => $this->allColumnsForReport(),
            'filters_text' => implode(' | ',$filters),
            'request' => $request,
        ]);

    }

    public function otherHrActions($slug){
        $employee = $this->findEmployeeBySlug($slug);
        return view('dashboard.employee.other_hr_actions.index')->with([
            'employee' => $employee,
        ]);
    }

    public function otherHrActionsPrint($slug, $type, Request $request){
        $employee = $this->findEmployeeBySlug($slug);
        if($type == 'nosa'){
            $oa = new HrOtherActions();
            $oa->employee_slug = $slug;
            $oa->type = $type;
            $oa->values = $request->all();
            $oa->save();
            return \view('printables.employee.nosa-hrs-034-02')->with([
                'employee' => $employee,
            ]);
        }

        if($type == 'coe'){
            return \view('printables.employee.coe')->with([
                'employee' => $employee,
            ]);
        }

        if($type == 'coe_with_compensation'){
            return \view('printables.employee.coe_with_compensation')->with([
                'employee' => $employee,
            ]);
        }

        if($type == 'nosi'){
            return \view('printables.employee.nosi')->with([
                'employee' => $employee,
            ]);
        }

        if($type == 'appointment_letter'){
            return \view('printables.employee.appointment_letter')->with([
                'employee' => $employee,
            ]);
        }


        return view('dashboard.employee.other_hr_actions.index')->with([
            'employee' => $employee,
        ]);
    }

    public function print($slug,$type){
        $employee = Employee::query()
            ->with(['employeeAddress'])
            ->where('slug','=',$slug)->first() ?? abort(404,'Employee not found.');
        if($type == 'pds'){
            return view('printables.hru.employee.pds_1')->with([
                'employee' => $employee
            ]);
        }
    }

    public function updatePhoto(Request $request,$slug){
        $file = $request->file;
        $employee = $this->findEmployeeBySlug($slug);
        $old_photo = $employee->photo;
        $name = $employee->firstname.' '.$employee->lastname;
        $name = str_replace(' ','-',$name);
        $fileName = $name.'-'.Str::random(3).'.'.$file->getClientOriginalExtension();




        if(\Storage::disk('symlinks')
            ->put('hrrs/employee_pics/uploaded/'.$fileName,$file->get())){
            //store image in different sizes

            foreach ($this->imageSizes() as $size){
                $new_image = Image::read($file);
                $new_image = $new_image->scaleDown(width: $size);
                $root = \Storage::disk('symlinks')->getConfig()['root'];
                $new_image->save($root.'/hrrs/employee_pics/uploaded_'.$size.'/'.$fileName);
            }

            $employee->photo = $fileName;
            $employee->save();
            if($old_photo != null){
                foreach ($this->imageSizes() as $size) {
                    \Storage::disk('symlinks')->delete('hrrs/employee_pics/uploaded_'.$size.'/'.$old_photo);
                }
                \Storage::disk('symlinks')->delete('hrrs/employee_pics/uploaded/'.$old_photo);
            }
            return true;
        }
        abort(503,'Error uploading file');
    }
    private function imageSizes(){
        return Arrays::imageSizes();
    }

    public function deletePhoto($slug){
        $employee = $this->findEmployeeBySlug($slug);
        $photo = $employee->photo;
        if($photo != null){
            foreach ($this->imageSizes() as $size) {
                \Storage::disk('symlinks')->delete('hrrs/employee_pics/uploaded_'.$size.'/'.$photo);
            }
            \Storage::disk('symlinks')->delete('hrrs/employee_pics/uploaded/'.$photo);
            $employee->photo = null;
            $employee->save();
            return 'Photo successfully removed.';
        }
        abort(503,'Error removing photo.');
    }

    public function allColumnsForReport(){
        return [
            'fullname' => [
                'name' => 'Fullname',
                'checked' => 1,
            ],
            'lastname' => [
                'name' => 'Last Name',
                'checked' => 0,
            ],
            'firstname' => [
                'name' => 'First Name',
                'checked' => 0,
            ],
            'middlename' => [
                'name' => 'Middle Name',
                'checked' => 0,
            ],
            'name_ext' => [
                'name' => 'Name Ext.',
                'checked' => 0,
            ],
            'sex' => [
                'name' => 'Sex',
                'checked' => 1,
            ],
            'date_of_birth' => [
                'name' => 'Birthday',
                'checked' => 0,
            ],
            'age' => [
                'name' => 'Age',
                'checked' => 0,
            ],
            'employee_no' => [
                'name' => 'Emp. No.',
                'checked' => 1,
            ],
            'item_no' => [
                'name' => 'Item No.',
                'checked' => 0,
            ],
            'position' => [
                'name' => 'Position',
                'checked' => 1,
            ],
            'dept_name' => [
                'name' => 'Department',
                'checked' => 0,
            ],
            'division' => [
                'name' => 'Division',
                'checked' => 0,
            ],
            'section' => [
                'name' => 'Section',
                'checked' => 0,
            ],

            'monthly_basic' => [
                'name' => 'Monthly Basic',
                'checked' => 1,
            ],
            'salary_grade' => [
                'name' => 'SG',
                'checked' => 0,
            ],
            'step_inc' => [
                'name' => 'SI',
                'checked' => 0,
            ],
            'firstday_gov' => [
                'name' => 'First Day in Government',
                'checked' => 0,
            ],
            'appointment_date' => [
                'name' => 'Appointment Date',
                'checked' => 0,
            ],
            'adjustment_date' => [
                'name' => 'Date of Last Promotion',
                'checked' => 0,
            ],
            'civil_status' => [
                'name' => 'Civil Status',
                'checked' => 0,
            ],
            'is_active' => [
                'name' => 'Status',
                'checked' => 1,
            ],
            'email' => [
                'name' => 'Email address',
                'checked' => 0,
            ],
            'locations' => [
                'name' => 'Location',
                'checked' => 1,
            ],
            'trainings' => [
                'name' => 'Trainings',
                'checked' => 0,
            ],
            'service_records' => [
                'name' => 'Service Records',
                'checked' => 0,
            ],
            'eligibility' => [
                'name' => 'Eligibility',
                'checked' => 0,
            ],
            'cs_eligibility_level' => [
                'name' => 'CS Level',
                'checked' => 0,
            ],
            'educational_background' => [
                'name' => 'Educational Background',
                'checked' => 0,
            ],
            'no_children' => [
                'name' => '# of children',
                'checked' => 0,
            ],
            'ra' => [
                'name' => 'Representation Allowance (RA)',
                'checked' => 0,
            ],
            'ta' => [
                'name' => 'Transportation Allowance (TA)',
                'checked' => 0,
            ],
            'tin' => [
                'name' => 'TIN',
                'checked' => 0,
            ],
            'gsis' => [
                'name' => 'GSIS',
                'checked' => 0,
            ],
            'philhealth' => [
                'name' => 'PhilHealth',
                'checked' => 0,
            ],
            'sss' => [
                'name' => 'SSS',
                'checked' => 0,
            ],
            'hdmf' => [
                'name' => 'HDMF',
                'checked' => 0,
            ],
            'assignment' => [
                'name' => 'Assignment',
                'checked' => 0,
            ]

        ];
    }

    public function generateQr($slug,Request $request){
        $employee = Employee::query()
            ->where('slug','=',$slug)
            ->first();

        if($request->has('get_qr')){
            $storage = \Storage::disk('local');
            $path = 'EMP_QR_CODE/'.$employee->employee_no.'.png';
            if($storage->exists($path)){
                $file = $storage->get($path);
                $type = 'png';
                $response = \Response::make($file, 200);
                $response->header("Content-Type", $type);
                return $response;
            }
            return  1;
        }

        $barcode = $employee->employee_no;
        $home = env('STORAGE_LOCATION','/home/swep_afd_storage/');
        $generator = new BarcodeGeneratorPNG();
        $temp_barcode_dir = $home.'/EMP_QR_CODE/';
        if (!is_dir($temp_barcode_dir)) {
            // dir doesn't exist, make it
            mkdir($temp_barcode_dir);
        }
        $image = QrCode::size('200')
            ->format('png')
            ->merge('/public/images/sra_only2.png',0.4)
            ->errorCorrection('H')
            ->generate($barcode);
        file_put_contents($temp_barcode_dir.$barcode.'.png', $image);



        return view('dashboard.employee.print_qr')->with([
            'employee' => $employee,
        ]);
    }


}
