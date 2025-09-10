<?php
 
namespace App\Swep\Services;

use App\Models\Employee;
use App\Swep\Interfaces\EmployeeInterface;
use App\Swep\Interfaces\DepartmentUnitInterface;

use App\Swep\BaseClasses\BaseService;
use App\Swep\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


class EmployeeService extends BaseService{




    protected $employee_repo;
    protected $dept_unit_repo;




    public function __construct(EmployeeRepository $employee_repo, DepartmentUnitInterface $dept_unit_repo){

        $this->employee_repo = $employee_repo;
        $this->dept_unit_repo = $dept_unit_repo;
        parent::__construct();

    }



    public function newEmployeeNo(Request $request){
        $digits = Carbon::parse($request->firstday_sra)->format('Y');
        $digits = preg_replace('/0/', '', $digits, 1);
        $lname = strtoupper(substr($request->lastname, 0, 1));
        if($request->middlename == null || $request->middlename == ''){
            $fname = strtoupper(substr($request->firstname, 0, 2));
            $mname = '';
        }else{
            $fname = strtoupper(substr($request->firstname, 0, 1));
            $mname = strtoupper(substr($request->middlename, 0, 1));
        }
        $empNo = $fname.$mname.$lname.$digits;
        //check if employee number is already used;
        $e = Employee::query()->where('employee_no','=',$empNo)->count();

        if($e > 0){
            $empNo = $fname;
        }

        dd($empNo);
    }




    public function fetch($request){

        $employees = $this->employee_repo->fetch($request);

        $request->flash();
        return view('dashboard.employee.index')->with('employees', $employees);
        
    }






    public function store($request){

        $employee = $this->employee_repo->store($request);
        $this->fillDependencies($request, $employee);
        return $employee->only('slug');
        //$this->event->dispatch('employee.store', $employee);
        return redirect()->back();

    }






     public function show($slug){

        $employee = $this->employee_repo->findBySlug($slug);
        return view('dashboard.employee.show')->with('employee', $employee);

    }






    public function edit($slug){

        $employee = $this->employee_repo->findBySlug($slug);
        return view('dashboard.employee.edit')->with('employee', $employee);

    }





    public function update($request, $slug){

        $employee = $this->employee_repo->update($request, $slug);


        $this->fillDependencies($request, $employee);

//        $this->event->dispatch('employee.update', $employee);
        return $employee->only('slug');
        return redirect()->route('dashboard.employee.index');

    }






    public function destroy($slug){

        $employee = $this->employee_repo->destroy($slug);
        return $employee;
//        $this->event->dispatch('employee.destroy', $employee);
//        return redirect()->back();

    }






    public function printPDS($slug, $page){

        $employee = $this->employee_repo->findBySlug($slug);

        if($page == 'p1'){
            return view('printables.employee.pds_p1')->with('employee', $employee);
        }elseif($page == 'p2'){
            return view('printables.employee.pds_p2')->with('employee', $employee);
        }elseif($page == 'p3'){
            return view('printables.employee.pds_p3')->with('employee', $employee);
        }elseif($page == 'p4'){
            return view('printables.employee.pds_p4')->with('employee', $employee);
        }elseif($page == 'p5'){
            return view('printables.employee.pds_p5')->with('employee', $employee);
        }

        return abort(404);

    }






    public function reportGenerate($request){



        if($request->r_type == 'ALPHA'){
            $employees = $this->employee_repo->getByIsActive('ACTIVE');
            return view('printables.employee.alphalist')->with('employees', $employees);
        }elseif($request->r_type == 'GEN'){
            $dept_units = $this->dept_unit_repo->getAll();
            return view('printables.employee.gender_count')->with('dept_units', $dept_units);
        }elseif($request->r_type == 'UNIT'){
            $dept_units = $this->dept_unit_repo->getAll();
            return view('printables.employee.by_unit')->with('dept_units', $dept_units);
        }elseif($request->r_type == 'RES_CITY') {
            //$dept_units = $this->dept_unit_repo->getAll();
            $employees = $this->employee_repo->getAllByResidentialAddressCity();
       
            return view('printables.employee.by_res_city')->with('employees',$employees);
        }else{
            abort(404);
        }





    }






    // Utils
    private function fillDependencies($request, $employee){

        // Employee Family Details, Address, Other Questions, Health Declaration
        $this->employee_repo->storeFamilyDetails($request, $employee);

        $this->employee_repo->storeAddress($request, $employee);
        $this->employee_repo->storeQuestions($request, $employee);
        $this->employee_repo->storeHealthDeclaration($request, $employee);

        // Employee Children
        if(!empty($request->row_children)){
            foreach ($request->row_children as $row) {
                $this->employee_repo->storeChildren($row, $employee);
            }
        }

        // Employee Educational Background
        if(!empty($request->row_eb)){
            foreach ($request->row_eb as $row) {
                $this->employee_repo->storeEducationalBackground($row, $employee);
            }
        }

        // Employee Eligibility
        if(!empty($request->row_eligibility)){
            foreach ($request->row_eligibility as $row) {
                $this->employee_repo->storeEligibility($row, $employee);
            }
        }

        // Employee Work Experience
        if(!empty($request->row_we)){
            foreach ($request->row_we as $row) {
                $this->employee_repo->storeExperience($row, $employee);
            }
        }

        // Employee Voluntary Works
        if(!empty($request->row_vw)){
            foreach ($request->row_vw as $row) {
                $this->employee_repo->storeVoluntaryWork($row, $employee);
            }
        }

        // Employee Recognition
        if(!empty($request->row_recognition)){
            foreach ($request->row_recognition as $row) {
                $this->employee_repo->storeRecognition($row, $employee);
            }
        }

        // Employee Organization
        if(!empty($request->row_org)){
            foreach ($request->row_org as $row) {
                $this->employee_repo->storeOrganization($row, $employee);
            }
        }

        // Employee Special Skills
        if(!empty($request->row_ss)){
            foreach ($request->row_ss as $row) {
                $this->employee_repo->storeSpecialSkill($row, $employee);
            }
        }

        // Employee Reference
        if(!empty($request->row_reference)){
            foreach ($request->row_reference as $row) {
                $this->employee_repo->storeReference($row, $employee);
            }
        }


        // Employee Medical Histories

        if(!empty($request->medical_histories)){
            foreach ($request->medical_histories as $key => $medical_history) {
                $this->employee_repo->storeMedicalHistory($medical_history, $request->medications[$key] , $employee);
            }
        }


    }


    public function findEmployeeBySlug($slug){
        return $slug;
    }

}