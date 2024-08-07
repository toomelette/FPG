<?php

namespace App\Swep\Repositories;
 
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\EmployeeTrainingInterface;
use App\Swep\Interfaces\EmployeeInterface;

use App\Models\EmployeeTraining;
use Carbon\Carbon;


class EmployeeTrainingRepository extends BaseRepository implements EmployeeTrainingInterface {
	



    protected $employee_trng;
    protected $employee_repo;




	public function __construct(EmployeeTraining $employee_trng, EmployeeRepository $employee_repo){

        $this->employee_trng = $employee_trng;
        $this->employee_repo = $employee_repo;
        parent::__construct();

    }






    public function fetchByEmployeeNo($slug){

        $employee = $this->employee_repo->findBySlug($slug);

        $employee_trngs = $this->cache->remember('employees:trainings:fetchByEmployeeNo:'. $employee->employee_no, 240, function() use ($employee){

            $employee_trng = $this->employee_trng->newQuery();

            return $this->populateByEmployeeNo($employee_trng, $employee->employee_no);

        });

        return ['employee' => $employee, 'employee_trainings' => $employee_trngs];

    }






    public function getByEmployeeNoWithFilter($request, $slug){

        $key = str_slug($request->fullUrl(), '_');

        $employee = $this->employee_repo->findBySlug($slug);

        $employee_trngs = $this->cache->remember('employees:trainings:getByEmployeeNoWithFilter:'. $employee->employee_no .':'. $key, 240, function() use ($employee, $request){

            $employee_trng = $this->employee_trng->newQuery();

            $df = $this->__dataType->date_parse($request->df);
            $dt = $this->__dataType->date_parse($request->dt);

            if(isset($request->df) || isset($request->dt)){
                $employee_trng->whereBetween('date_from', [$df, $dt]);
            }

            return $this->populateByEmployeeNo($employee_trng, $employee->employee_no);

        });

        return ['employee' => $employee, 'employee_trainings' => $employee_trngs];

    }






    public function store($request, $slug){

        $employee = $this->employee_repo->findBySlug($slug);
        $employee_trng = new EmployeeTraining;
        $employee_trng->employee_slug = $employee->slug;
        $employee_trng->slug = $this->str->random(32);
        $employee_trng->employee_no = $employee->employee_no;
        $employee_trng->sequence_no = $request->sequence_no;
        $employee_trng->title = $request->title;
        $employee_trng->type = $request->type;
        $employee_trng->date_from = $this->__dataType->date_parse($request->date_from);
        $employee_trng->date_to = $this->__dataType->date_parse($request->date_to);

        $employee_trng->detailed_period = $request->detailed_period;
        $employee_trng->hours = $request->hours;
        $employee_trng->conducted_by = $request->conducted_by;
        $employee_trng->venue = $request->venue;
        $employee_trng->remarks = $request->remarks;
        $employee_trng->is_relevant = $this->__dataType->string_to_boolean($request->is_relevant);
        $employee_trng->created_at = $this->carbon->now();
        $employee_trng->updated_at = $this->carbon->now();
        $employee_trng->ip_created = request()->ip();
        $employee_trng->ip_updated = request()->ip();
        $employee_trng->user_created = $this->auth->user()->user_id;
        $employee_trng->user_updated = $this->auth->user()->user_id;
        $employee_trng->save();

        return $employee_trng;

    }






    public function update($request, $slug){

        $employee_trng = $this->findBySlug($slug);
        $employee_trng->sequence_no = $request->sequence_no;
        $employee_trng->title = $request->title;
        $employee_trng->type = $request->type;
        $employee_trng->date_from = $this->__dataType->date_parse($request->date_from);
        $employee_trng->date_to = $this->__dataType->date_parse($request->date_to);
        $employee_trng->detailed_period = $request->detailed_period;

        $employee_trng->hours = $request->hours;
        $employee_trng->conducted_by = $request->conducted_by;
        $employee_trng->venue = $request->venue;
        $employee_trng->remarks = $request->remarks;
        $employee_trng->is_relevant = $this->__dataType->string_to_boolean($request->is_relevant);
        $employee_trng->updated_at = $this->carbon->now();
        $employee_trng->ip_updated = request()->ip();
        $employee_trng->user_updated = $this->auth->user()->user_id;
        $employee_trng->update();

        return $employee_trng;

    }






    public function destroy($slug){

        $employee_trng = $this->findBySlug($slug);
        $employee_trng->delete();

        return $employee_trng;

    }





    public function populateByEmployeeNo($model, $employee_no){

        return $model->where('employee_no', $employee_no)
                     ->orderBy('date_from', 'desc')
                     ->get();

    }





    public function findBySlug($slug){
            
        $employee_trng = $this->employee_trng->where('slug', $slug)->first();

        if(empty($employee_trng)){
            abort(404);
        }

        return $employee_trng;

    }





    public function getBySlug($slug){
            
        $employee_trng = $this->cache->remember('employees:trainings:getBySlug:'. $slug .'', 240, function() use ($slug){
            return $this->employee_trng->where('slug', $slug)->get();
        });

        return $employee_trng;

    }






}