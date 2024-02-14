<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEligibility extends Model{




//    protected $connection = 'server5';
	protected $table = 'hr_employee_eligibilities';

    protected $dates = ['exam_date'];

    public $timestamps = false;
    

    use SoftDeletes;



    protected $attributes = [
        
        'employee_no' => '',
        'eligibility' => '',
        'level' => '',
        'rating' => null,
        'exam_place' => '',
        'exam_date' => null,
        'license_no' => '',
        'license_validity' => null,

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }
    



    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('exam_date', 'desc')->get();

    }




    
}
