<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;

class EmployeeOtherQuestion extends Model{




    protected $connection = 'afd_qc';
	protected $table = 'hr_employee_other_questions';

    public $timestamps = false;




    

	protected $attributes = [
        
        'employee_no' => '',
        'q_34_a' => '',
        'q_34_b' => '',
        'q_34_b_yes_details' => '',
        'q_35_a' => '',
        'q_35_a_yes_details' => '',
        'q_35_b' => '',
        'q_35_b_yes_details_1' => '',
        'q_35_b_yes_details_2' => '',
        'q_36' => '',
        'q_36_yes_details' => '',
        'q_37' => '',
        'q_37_yes_details' => '',
        'q_38_a' => '',
        'q_38_a_yes_details' => '',
        'q_38_b' => '',
        'q_38_b_yes_details' => '',
        'q_39' => '',
        'q_39_yes_details' => '',
        'q_40_a' => '',
        'q_40_a_yes_details' => '',
        'q_40_b' => '',
        'q_40_b_yes_details' => '',
        'q_40_c' => '',
        'q_40_c_yes_details' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }






    
}
