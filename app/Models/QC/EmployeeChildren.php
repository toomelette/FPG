<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;

class EmployeeChildren extends Model{



    protected $connection = 'afd_qc';

	protected $table = 'hr_employee_children';

    protected $dates = ['date_of_birth'];

    public $timestamps = false;
    




    protected $attributes = [
        
        'employee_no' => '',
        'fullname' => '',
        'date_of_birth' => null,
        'school_company' => '',
        'civil_status' => '',

    ];







    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }
    





    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('date_of_birth', 'desc')->get();

    }
    




    
}
