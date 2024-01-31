<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;

class EmployeeSpecialSkill extends Model{




    protected $connection = 'afd_qc';

	protected $table = 'hr_employee_special_skills';

    public $timestamps = false;




    

    protected $attributes = [
        
        'employee_no' => '',
        'description' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }
    


    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('description', 'desc')->get();

    }







    
}
