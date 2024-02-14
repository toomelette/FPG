<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeMatrix extends Model{



	protected $table = 'hr_employee_matrix';

    public $timestamps = false;
    



    protected $attributes = [
        
        'employee_no' => '',
        'educ_bachelors_degree' => 0.00,
        'educ_undergrad_bachelor_units_earned' => 0.00,
        'educ_undergrad_bachelor' => 0.00,
        'educ_masters_degree' => 0.00,
        'educ_doctoral_degree' => 0.00,
        'educ_undergrad_masteral_units_earned' => 0.00,
        'educ_undergrad_masteral' => 0.00,
        'educ_grad_certificate_course' => 0.00,
        'educ_distinctions_summa_cum_laude' => 0.00,
        'educ_distinctions_magna_cum_laude' => 0.00,
        'educ_distinctions_cum_laude' => 0.00,
        'educ_distinctions_pres_awardee' => 0.00,
        'educ_distinctions_csc_sra_da_awardee' => 0.00,
        'educ_distinctions_top_gov_exam' => 0.00,
        'experience_years' => 0.00,
        'experience_req_years' => 0.00,
        'experience' => 0.00,
        'training_no' => 0.00,
        'training_req_no' => 0.00,
        'training' => 0.00,
        'eligibility' => 0.00,
        'performance' => 0.00,
        'behavior_point_score' => 0.00,
        'behavior' => 0.00,
        'psycho_test_point_score' => 0.00,
        'psycho_test' => 0.00,

    ];




    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }




    
}
