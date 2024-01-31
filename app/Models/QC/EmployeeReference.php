<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;

class EmployeeReference extends Model{




    protected $connection = 'afd_qc';
	protected $table = 'hr_employee_references';

    public $timestamps = false;
    





    protected $attributes = [
        
        'employee_no' => '',
        'fullname' => '',
        'address' => '',
        'tel_no' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }
    




    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('fullname', 'desc')->get();

    }






   
}
