<?php

namespace App\Http\Controllers;


use App\Http\Requests\EmployeeServiceRecord\EmployeeServiceRecordCreateForm;
use App\Http\Requests\EmployeeTraining\EmployeeTrainingCreateForm;
use App\Models\EmployeeChildren;
use App\Models\EmployeeEducationalBackground;
use App\Models\EmployeeEligibility;
use App\Models\EmployeeExperience;
use App\Models\EmployeeFamilyDetail;
use App\Models\EmployeeServiceRecord;
use App\Models\EmployeeTraining;
use App\Models\User;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Swep\Services\ProfileService;
use App\Http\Requests\Profile\ProfileUpdateAccountUsernameRequest;
use App\Http\Requests\Profile\ProfileUpdateAccountPasswordRequest;
use App\Http\Requests\Profile\ProfileUpdateAccountColorRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller{



	protected $profile_service; 



    public function __construct(ProfileService $profile_service){

        $this->profile_service = $profile_service;

    }

    public function index()
    {
        return view('_profile.index')->with([
            'employee' => Auth::user()->employee,
        ]);
    }



	public function details(){
        $user = User::query()
            ->with([
                'employee.employeeServiceRecord',
                'employee.employeeTraining',
                'employee.plantilla',
            ])
            ->find(\Auth::user()->id);

        return view('dashboard.profile.details')->with([
            'user' => $user,
        ]);
        
    }




    public function updateAccountUsername(ProfileUpdateAccountUsernameRequest $request, $slug){

        return $this->profile_service->updateAccountUsername($request, $slug);
        
    }




    public function updateAccountPassword(ProfileUpdateAccountPasswordRequest $request, $slug){

        return $this->profile_service->updateAccountPassword($request, $slug);
        
    }


    

    public function updateAccountColor(ProfileUpdateAccountColorRequest $request, $slug){

        return $this->profile_service->updateAccountColor($request, $slug);
        
    }


    

    public function printPds($slug, $page){
        return $this->profile_service->printPds($slug, $page);
    }


    public function saveFamilyInfo(Request $request){
        $employee = $this->findEmployeeLinkedToThisAccount();
        $employee_no = \Auth::user()->employee->employee_no;
        $status = 1;
        //Save Family Info
        if(!empty($employee->employeeFamilyDetail)){
            $fd = $employee->employeeFamilyDetail;
            $fd->spouse_lastname = $request->spouse_lastname;
            $fd->spouse_firstname = $request->spouse_firstname;
            $fd->spouse_middlename = $request->spouse_middlename;
            $fd->spouse_name_ext = $request->spouse_name_ext;
            $fd->spouse_birthdate = $request->spouse_birthdate;
            $fd->spouse_occupation = $request->spouse_occupation;
            $fd->spouse_employer = $request->spouse_employer;
            $fd->spouse_business_address = $request->spouse_business_address;
            $fd->spouse_tel_no = $request->spouse_tel_no;
            $fd->father_lastname = $request->father_lastname;
            $fd->father_firstname = $request->father_firstname;
            $fd->father_middlename = $request->father_middlename;
            $fd->father_name_ext = $request->father_name_ext;
            $fd->mother_lastname = $request->mother_lastname;
            $fd->mother_firstname = $request->mother_firstname;
            $fd->mother_middlename = $request->mother_middlename;
            $fd->mother_name_ext = $request->mother_name_ext;
            $fd->save();
        }else{
            $fd = new EmployeeFamilyDetail;
            $fd->employee_no = $employee_no;
            $fd->spouse_lastname = $request->spouse_lastname;
            $fd->spouse_firstname = $request->spouse_firstname;
            $fd->spouse_middlename = $request->spouse_middlename;
            $fd->spouse_name_ext = $request->spouse_name_ext;
            $fd->spouse_birthdate = $request->spouse_birthdate;
            $fd->spouse_occupation = $request->spouse_occupation;
            $fd->spouse_employer = $request->spouse_employer;
            $fd->spouse_business_address = $request->spouse_business_address;
            $fd->spouse_tel_no = $request->spouse_tel_no;
            $fd->father_lastname = $request->father_lastname;
            $fd->father_firstname = $request->father_firstname;
            $fd->father_middlename = $request->father_middlename;
            $fd->father_name_ext = $request->father_name_ext;
            $fd->mother_lastname = $request->mother_lastname;
            $fd->mother_firstname = $request->mother_firstname;
            $fd->mother_middlename = $request->mother_middlename;
            $fd->mother_name_ext = $request->mother_name_ext;
            $fd->save();


        }

        $employee->employeeChildren()->delete();
        if(!empty($request->fullname)){
            if(count($request->fullname) > 0){
                $childrenArr = [];
                $count = count($request->fullname);
                for($x = 0; $x <= $count-1;$x++){
                    if($request->fullname[$x] != ''){
                        array_push($childrenArr,[
                            'employee_no' => $employee_no,
                            'fullname' => $request->fullname[$x],
                            'date_of_birth' => Carbon::parse($request->date_of_birth[$x])->format('Y-m-d'),
                            'school_company' => $request->school_company[$x],
                            'civil_status' => $request->civil_status[$x],
                        ]);
                    }
                }
                $children = EmployeeChildren::insert($childrenArr);
            }
        }
        if($status == 1){
            return 1;
        }else{
            abort(503, 'Error saving family information');
        }
    }

    private function findEmployeeLinkedToThisAccount(){
        if(empty(\Auth::user()->employee)){
            abort(503,'Employee cannot be null');
        }
        $emp  = \Auth::user()->employee;
        return $emp;
    }

    //SERVICE RECORDS
        public function serviceRecord(EmployeeController $employeeController){
            return $employeeController->serviceRecord(Auth::user()->employee->slug);
        }

        public function serviceRecordStore(EmployeeController $employeeController, EmployeeServiceRecordCreateForm $request){
            return $employeeController->serviceRecordStore($request,Auth::user()->employee->slug);
        }
        public function serviceRecordUpdate(EmployeeServiceRecordCreateForm $request,$slug, EmployeeController $employeeController){
            $this->checkPermissionSr($slug);
            return $employeeController->serviceRecordUpdate($request,$slug);
        }
        public function serviceRecordDestroy(EmployeeController $employeeController,$slug){
            $this->checkPermissionSr($slug);
            return $employeeController->serviceRecordDestroy($slug);
        }

        private function checkPermissionSr($service_record_slug){
            $sr = EmployeeServiceRecord::query()->where('slug' , '=',$service_record_slug)->first();
            if(Auth::user()->employee_no !== $sr->employee_no){
                abort(503,'Insufficient permission.');
            }
        }


    //TRAININGS
        private function checkPermissionTraining($training_slug){
            $training = EmployeeTraining::query()->where('slug' , '=',$training_slug)->first();
            if(Auth::user()->employee_no !== $training->employee_no){
                abort(503,'Insufficient permission.');
            }
        }

        public function training(EmployeeController $employeeController){
            return $employeeController->training(Auth::user()->employee->slug);
        }
        public function trainingStore(EmployeeTrainingCreateForm $request, EmployeeController $employeeController){
            return $employeeController->trainingStore($request,Auth::user()->employee->slug);
        }

        public function trainingUpdate(EmployeeTrainingCreateForm $request, $training_slug, EmployeeController $employeeController){
            $this->checkPermissionTraining($training_slug);
            return $employeeController->trainingUpdate($request,$training_slug);
        }

        public function trainingDestroy($training_slug, EmployeeController $employeeController){
            $this->checkPermissionTraining($training_slug);
            return $employeeController->trainingDestroy($training_slug);
        }

    //EDUCATION
        public function educationalBackgroundStore(Request $request){
            if(!empty($request->level)){
                Auth::user()->employee->employeeEducationalBackground()->delete();
                $emp_no = Auth::user()->employee->employee_no;
                $educArr = [];
                for($x = 0; $x < count($request->level); $x ++){
                    if($request->level[$x] !== ''){
                        array_push($educArr,[
                            'employee_no' => $emp_no,
                            'level' => $request->level[$x],
                            'school_name' => $request->school_name[$x],
                            'course' => $request->course[$x],
                            'date_from' => $request->date_from[$x],
                            'date_to' => $request->date_to[$x],
                            'units' => $request->units[$x],
                            'graduate_year' => $request->graduate_year[$x],
                            'scholarship' => $request->scholarship[$x],
                        ]);
                    }
                }
                $i = EmployeeEducationalBackground::insert($educArr);
                if($i){
                    abort('200','Done');
                }else{
                    abort(503,'Error saving data.');
                }
            }
            abort('200','Done');
        }
    //ELIGIBILITY
        public function eligibilityStore(Request $request){
            if(!empty($request->eligibility)){
                Auth::user()->employee->employeeEligibility()->delete();
                $emp_no = Auth::user()->employee->employee_no;
                $eligArr = [];

                for ($x = 0; $x < count($request->eligibility); $x++){
                    if($request->eligibility[$x] !== ''){
                        array_push($eligArr,[
                            'employee_no' => $emp_no,
                            'eligibility' => $request->eligibility[$x],
                            'level' => $request->level[$x],
                            'rating' => $request->rating[$x],
                            'exam_place' => $request->exam_place[$x],
                            'exam_date' => $request->exam_date[$x],
                            'license_no' => $request->license_no[$x],
                            'license_validity' => $request->license_validity[$x],
                        ]);
                    }
                }


                $i = EmployeeEligibility::insert($eligArr);

                if($i){
                    abort(200, 'Done with new data.');
                }else{
                    abort(503,'Error saving data.');
                }
            }else{
                abort(200,'Done without making changes.');
            }
        }

    //WORK EXPERIENCE
    public function workExperienceStore(Request $request){
        if(!empty($request->company)){
            Auth::user()->employee->employeeExperience()->delete();
            $emp_no = Auth::user()->employee->employee_no;
            $weArr = [];

            for ($x = 0; $x < count($request->company); $x++){
                if($request->company[$x] !== ''){
                    array_push($weArr,[
                        'employee_no' =>  $emp_no,
                        'date_from' => $request->date_from[$x],
                        'date_to' => $request->date_to[$x],
                        'position' => $request->position[$x],
                        'company' => $request->company[$x],
                        'salary' => Helper::sanitizeAutonum($request->salary[$x]),
                        'salary_grade' => $request->salary_grade[$x],
                        'appointment_status' => $request->appointment_status[$x],
                        'is_gov_service' => $request->is_gov_service[$x],
                    ]);
                }
            }
            $i = EmployeeExperience::insert($weArr);
            if($i){
                abort(200, 'Done with new data.');
            }else{
                abort(503,'Error saving data.');
            }
        }else{
            abort(200,'Done without making changes.');
        }
    }

    public function selectTheme(Request $request){

        $id =  Auth::user()->id;
        $u = User::find($id);
        $u->color = $request->theme;
        if($u->save()){
            return array_search($request->theme , Helper::user_colors());
        }
        abort(503, 'Error saving theme.');
    }
}
