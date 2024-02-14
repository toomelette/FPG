<?php

namespace App\Swep\Repositories;
 
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\EmployeeMatrixInterface;


use App\Models\EmployeeMatrix;


class EmployeeMatrixRepository extends BaseRepository implements EmployeeMatrixInterface {
	


    protected $employee_matrix;



	public function __construct(EmployeeMatrix $employee_matrix){

        $this->employee_matrix = $employee_matrix;
        parent::__construct();

    }





    public function store($request, $employee_no){


        $employee_matrix = new EmployeeMatrix;
        $employee_matrix->employee_no = $employee_no;
        $employee_matrix->educ_bachelors_degree = $request->educ_bachelors_degree;
        $employee_matrix->educ_undergrad_bachelor_units_earned = $request->educ_undergrad_bachelor_units_earned;
        $employee_matrix->educ_undergrad_bachelor = $request->educ_undergrad_bachelor;
        $employee_matrix->educ_masters_degree = $request->educ_masters_degree;
        $employee_matrix->educ_doctoral_degree = $request->educ_doctoral_degree;
        $employee_matrix->educ_undergrad_masteral_units_earned = $request->educ_undergrad_masteral_units_earned;
        $employee_matrix->educ_undergrad_masteral = $request->educ_undergrad_masteral;
        $employee_matrix->educ_grad_certificate_course = $request->educ_grad_certificate_course;
        $employee_matrix->educ_distinctions_summa_cum_laude = $request->educ_distinctions_summa_cum_laude;
        $employee_matrix->educ_distinctions_magna_cum_laude = $request->educ_distinctions_magna_cum_laude;
        $employee_matrix->educ_distinctions_cum_laude = $request->educ_distinctions_cum_laude;
        $employee_matrix->educ_distinctions_pres_awardee = $request->educ_distinctions_pres_awardee;
        $employee_matrix->educ_distinctions_csc_sra_da_awardee = $request->educ_distinctions_csc_sra_da_awardee;
        $employee_matrix->educ_distinctions_top_gov_exam = $request->educ_distinctions_top_gov_exam;
        $employee_matrix->experience_req_years = $request->experience_req_years;
        $employee_matrix->experience_years = $request->experience_years;
        $employee_matrix->experience = $request->experience;
        $employee_matrix->training_req_no = $request->training_req_no;
        $employee_matrix->training_no = $request->training_no;
        $employee_matrix->training = $request->training;
        $employee_matrix->eligibility = $request->eligibility;
        $employee_matrix->performance = $request->performance;
        $employee_matrix->behavior_point_score = $request->behavior_point_score;
        $employee_matrix->behavior = $request->behavior;
        $employee_matrix->psycho_test_point_score = $request->psycho_test_point_score;
        $employee_matrix->psycho_test = $request->psycho_test;

        $employee_matrix->save();

        return $employee_matrix;

    }






}