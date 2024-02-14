<?php

namespace App\Swep\Repositories;
 
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Helpers\Helper;
use App\Swep\Interfaces\EmployeeServiceRecordInterface;
use App\Swep\Interfaces\EmployeeInterface;

use App\Models\EmployeeServiceRecord;


class EmployeeServiceRecordRepository extends BaseRepository implements EmployeeServiceRecordInterface {
	



    protected $employee_sr;
    protected $employee_repo;




	public function __construct(EmployeeServiceRecord $employee_sr, EmployeeInterface $employee_repo){

        $this->employee_sr = $employee_sr;
        $this->employee_repo = $employee_repo;
        parent::__construct();

    }






    public function fetchByEmpNo($slug){

        $employee = $this->employee_repo->findBySlug($slug);
        $employee_sr = $this->employee_sr->newQuery()->orderBy('sequence_no','asc');
        return $this->populate($employee_sr ,$employee->employee_no);

        $employee_service_records = $this->cache->remember('employees:service_records:fetchByEmpNo:'. $employee->employee_no, 240, function() use ($employee){
            $employee_sr = $this->employee_sr->newQuery();
            return $this->populate($employee_sr ,$employee->employee_no);
        });

    
        return ['employee' => $employee, 'employee_service_records' => $employee_service_records];


    }





    public function store($request, $slug){

        $employee = $this->employee_repo->findBySlug($slug);
        $employee_sr = new EmployeeServiceRecord;
        $employee_sr->slug = $this->str->random(32);
        $employee_sr->employee_slug = $employee->slug;
        $employee_sr->employee_no = $employee->employee_no;
        $employee_sr->sequence_no = $request->sequence_no;
        $employee_sr->from_date = $request->from_date;
        $employee_sr->to_date = $request->to_date ?? null;
        $employee_sr->position = $request->position;
        $employee_sr->appointment_status = $request->appointment_status;
        $employee_sr->salary = Helper::sanitizeAutonum($request->salary);
        $employee_sr->mode_of_payment = $request->mode_of_payment;
        $employee_sr->station = $request->station;
        $employee_sr->gov_serve = $request->gov_serve;
        $employee_sr->psc_serve = $request->psc_serve;
        $employee_sr->lwp = $request->lwp;
        if($request->upto_date == true){
            $employee_sr->upto_date = 1;
        }else{
            $employee_sr->upto_date = 0;
        }
        $employee_sr->spdate = $request->spdate;
        $employee_sr->status = $request->status;
        $employee_sr->remarks = $request->remarks;
        $employee_sr->created_at = $this->carbon->now();
        $employee_sr->updated_at = $this->carbon->now();
        $employee_sr->ip_created = request()->ip();
        $employee_sr->ip_updated = request()->ip();
        $employee_sr->user_created = $this->auth->user()->user_id;
        $employee_sr->user_updated = $this->auth->user()->user_id;
        $employee_sr->save();

        return $employee_sr;

    }






    public function update($request, $slug){

        $employee_sr = $this->findBySlug($slug);
        $employee_sr->sequence_no = $request->sequence_no;
        $employee_sr->from_date = $request->from_date;
        $employee_sr->to_date = $request->to_date ?? null;
        $employee_sr->position = $request->position;
        $employee_sr->appointment_status = $request->appointment_status;
        $employee_sr->salary = Helper::sanitizeAutonum($request->salary);
        $employee_sr->mode_of_payment = $request->mode_of_payment;
        $employee_sr->station = $request->station;
        $employee_sr->gov_serve = $request->gov_serve;
        $employee_sr->psc_serve = $request->psc_serve;
        $employee_sr->lwp = $request->lwp;
        $employee_sr->spdate = $request->spdate;
        $employee_sr->status = $request->status;
        $employee_sr->remarks = $request->remarks;
        $employee_sr->updated_at = $this->carbon->now();
        $employee_sr->ip_updated = request()->ip();
        $employee_sr->user_updated = $this->auth->user()->user_id;
        if($request->upto_date == true){
            $employee_sr->upto_date = 1;
        }else{
            $employee_sr->upto_date = 0;
        }


        $employee_sr->update();

        return $employee_sr;

    }






    public function destroy($slug){
        
        $employee_sr = $this->findBySlug($slug);
        $employee_sr->delete();

        return $employee_sr;

    }






    public function populate($model, $employee_no){

        return $model->where('employee_no', $employee_no)
                     ->orderBy('sequence_no', 'asc')
                     ->get();

    }





    public function findBySlug($slug){

        $employee_sr = $this->employee_sr->where('slug', $slug)->first(); 

        if(empty($employee_sr)){
            abort(404);
        }

        return $employee_sr;

    }





    public function getBySlug($slug){
        return $this->employee_sr->where('slug', $slug)->get();
        $employee_sr = $this->cache->remember('employees:service_records:getBySlug:'. $slug .'', 240, function() use ($slug){
            return $this->employee_sr->where('slug', $slug)->get();
        });
        
        return $employee_sr;

    }






}