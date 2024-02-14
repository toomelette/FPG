<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyDetail extends Model{





	protected $table = 'hr_employee_family_details';

    public $timestamps = false;





	protected $attributes = [
        
        'employee_no' => '',
        'spouse_lastname' => '',
        'spouse_firstname' => '',
        'spouse_middlename' => '',
        'spouse_name_ext' => '',
        'spouse_occupation' => '',
        'spouse_birthdate' => null,
        'spouse_employer' => '',
        'spouse_business_address' => '',
        'spouse_tel_no' => '',
        'father_lastname' => '',
        'father_firstname' => '',
        'father_middlename' => '',
        'father_name_ext' => '',
        'mother_lastname' => '',
        'mother_firstname' => '',
        'mother_middlename' => '',
        'mother_name_ext' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }
    
    


    

    
}
