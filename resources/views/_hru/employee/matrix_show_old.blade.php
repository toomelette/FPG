<?php
  
  $total_score = optional($employee->employeeMatrix)->educ_bachelors_degree + 
                 optional($employee->employeeMatrix)->educ_undergrad_bachelor + 
                 optional($employee->employeeMatrix)->educ_masters_degree + 
                 optional($employee->employeeMatrix)->educ_doctoral_degree + 
                 optional($employee->employeeMatrix)->educ_undergrad_masteral + 
                 optional($employee->employeeMatrix)->educ_grad_certificate_course + 

                 optional($employee->employeeMatrix)->educ_distinctions_summa_cum_laude + 
                 optional($employee->employeeMatrix)->educ_distinctions_magna_cum_laude + 
                 optional($employee->employeeMatrix)->educ_distinctions_cum_laude + 
                 optional($employee->employeeMatrix)->educ_distinctions_pres_awardee + 
                 optional($employee->employeeMatrix)->educ_distinctions_csc_sra_da_awardee + 
                 optional($employee->employeeMatrix)->educ_distinctions_top_gov_exam + 

                 optional($employee->employeeMatrix)->experience + 
                 optional($employee->employeeMatrix)->training +
                 optional($employee->employeeMatrix)->eligibility + 
                 optional($employee->employeeMatrix)->performance + 
                 optional($employee->employeeMatrix)->behavior + 
                 optional($employee->employeeMatrix)->psycho_test;

?>

@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    <h1>Employee Matrix</h1>
    <div class="pull-right" style="margin-top: -25px;">
      {!! __html::back_button(['dashboard.employee.index']) !!}
    </div>

</section>

<section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Matrix Details</h3>
        <div class="box-tools">
          <a href="{{ route('dashboard.employee.matrix', $employee->slug) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Edit</a>
          &nbsp;
          <a href="{{ route('dashboard.employee.matrix_print', $employee->slug) }}" target="_blank" class="btn btn-sm btn-default">
            <i class="fa fa-print"></i> Print 
          </a>
        </div>

      </div>
      
      <div class="box-body">


        {{-- DOC Info --}}
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">

              <h4>Education - Relevant to the Position</h4>

              <ul>
                  
                <li>Bachelor's Degree Graduate = <b>{{ number_format(optional($employee->employeeMatrix)->educ_bachelors_degree, 2) }}</b></li>
                <li>College Undergraduate = <b>{{ number_format(optional($employee->employeeMatrix)->educ_undergrad_bachelor, 2) }}</b></li>
                <li>Master's Degree = <b>{{ number_format(optional($employee->employeeMatrix)->educ_masters_degree, 2) }}</b></li>
                <li>Doctoral Degree Graduate = <b>{{ number_format(optional($employee->employeeMatrix)->educ_doctoral_degree, 2) }}</b></li>
                <li>Undergraduate Masteral / Doctoral = <b>{{ number_format(optional($employee->employeeMatrix)->educ_undergrad_masteral, 2) }}</b></li>
                <li>Graduate Certificate Course = <b>{{ number_format(optional($employee->employeeMatrix)->educ_grad_certificate_course, 2) }}</b></li>

                <li>Bachelor's Degree Graduate
                  <ul>  
                      <li>Summa Cum Laude = <b>{{ number_format(optional($employee->employeeMatrix)->educ_distinctions_summa_cum_laude, 2) }}</b></li>
                      <li>Magna Cum Laude = <b>{{ number_format(optional($employee->employeeMatrix)->educ_distinctions_magna_cum_laude, 2) }}</b></li>
                      <li>Cum Laude / With Honors = <b>{{ number_format(optional($employee->employeeMatrix)->educ_distinctions_cum_laude, 2) }}</b></li>
                      <li>Presidential Awardee = <b>{{ number_format(optional($employee->employeeMatrix)->educ_distinctions_pres_awardee, 2) }}</b></li>
                      <li>CSC / SRA / DA Awardee = <b>{{ number_format(optional($employee->employeeMatrix)->educ_distinctions_csc_sra_da_awardee, 2) }}</b></li>
                      <li>Top 10 on government licensure administered exams = <b>{{ number_format(optional($employee->employeeMatrix)->educ_distinctions_top_gov_exam, 2) }}</b></li>
                  </ul>
                </li>

              </ul>


              <h4>Experience = <b>{{ number_format(optional($employee->employeeMatrix)->experience, 2) }}</b></h4>

              <h4>Training = <b>{{ number_format(optional($employee->employeeMatrix)->training, 2) }}</b></h4>

              <h4>Eligibility = <b>{{ number_format(optional($employee->employeeMatrix)->eligibility, 2) }}</b></h4>

              <h4>Performance = <b>{{ number_format(optional($employee->employeeMatrix)->performance, 2) }}</b></h4>

              <h4>Behavioral Events, Interview, Assesment (BEIA), Work Attitude = <b>{{ number_format(optional($employee->employeeMatrix)->behavior, 2) }}</b></h4>

              <h4>Psychological and Mental Aptitude Tests = <b>{{ number_format(optional($employee->employeeMatrix)->psycho_test, 2) }}</b></h4>

              <h3>Total Score = {{ $total_score }}</h3>


            </div>
          </div>
        </div>
      
      </div>
    </div>

</section>

@endsection

