<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeHealthDeclaration extends Model{





	protected $table = 'hr_employee_health_declaration';

    public $timestamps = false;




    

	protected $attributes = [
        
        'family_doctor' => '',
        'contact_person' => '',
        'contact_person_phone' => '',
        'cities_ecq' => '',
        'been_sick' => '',
        'been_sick_yes_details' => '',
        'fever_colds' => '',
        'fever_colds_yes_details' => '',
        'smoking' => '',
        'smoking_yes_details' => '',
        'drinking' => '',
        'drinking_yes_details' => '',
        'taking_drugs' => '',
        'taking_drugs_yes_details' => '',
        'taking_vitamins' => '',
        'taking_vitamins_yes_details' => '',
        'eyeglasses' => '',
        'eyeglasses_yes_details' => '',
        'exercise' => '',
        'exercise_yes_details' => '',
        'being_treated' => '',
        'being_treated_yes_details' => '',
        'chronic_injuries' => '',
        'chronic_injuries_yes_details' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }






    
}
