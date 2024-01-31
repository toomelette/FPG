<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployeeTraining extends Model{


    protected $connection = 'afd_qc';

    protected $table = 'hr_employee_trainings';

    protected $dates = ['date_from', 'date_to', 'created_at', 'updated_at'];

    public $timestamps = false;
    use SoftDeletes;

    


    protected $attributes = [
        
        'employee_no' => '',
        'slug' => '',
        'title' => '',
        'type' => '',
        'date_from' => null,
        'date_to' => null,
        'hours' => null,
        'conducted_by' => '',
        'venue' => '',
        'remarks' => '',
        'is_relevant' => false,
        'created_at' => null, 
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }
    




    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('date_to', 'desc')->get();

    }





}
