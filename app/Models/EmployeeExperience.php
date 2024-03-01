<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeExperience extends Model{




//    protected $connection = 'server5';
	protected $table = 'hr_employee_experiences';

    protected $dates = ['date_from', 'date_to'];

    public $timestamps = false;
    
    use SoftDeletes;

    protected $touches = ['employee'];


    protected $attributes = [
        
        'employee_no' => '',
        'date_from' => null,
        'date_to' => null,
        'position' => '',
        'company' => '',
        'salary' => 0.00,
        'salary_grade' => 0,
        'appointment_status' => '',
        'is_gov_service' => false,

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }
    




    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('date_from', 'desc')->get();

    }





    
}
