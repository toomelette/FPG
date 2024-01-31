<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;

class EmployeeMedicalHistory extends Model{



    protected $connection = 'afd_qc';

	protected $table = 'hr_employee_medical_history';

    public $timestamps = false;




    

	protected $attributes = [
        
        'employee_no' => '',
        'medical_history' => '',
        'medication' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }






    
}
