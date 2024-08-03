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

    $rand = \Illuminate\Support\Str::random(15);
?>

@extends('layouts.modal-content')

@section('modal-header')
    <i class="fa fa-dashboard"></i> {{$employee->lastname}}, {{$employee->firstname}} - Matrix
@endsection

@section('modal-body')

    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="row">
                <div class="col-md-6">
                    <h3 class="panel-title">Matrix Details</h3>
                </div>
                <div class="col-md-6">
                    <div class="btn-group pull-right btn-group-sm" role="group" aria-label="...">
                        <button class="btn btn-default pull-left btn-sm" data-toggle="modal" data-target="#print_training_modal"><i class="fa fa-print"></i> Print</button>
                        <button class="btn btn-primary pull-right btn-sm" data-toggle="modal" onclick="clicks('aa')" id="aa" data-target="#edit_matrix_modal"><i class="fa fa-edit"></i> Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">

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

@endsection

@section('modal-footer')
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#edit_matrix_btn_{{$rand}}").click(function () {
        btn = $(this);
        load_modal2(btn);
        uri = "{{route('dashboard.employee.matrix','slug')}}";
        uri = uri.replace('slug','{{$employee->slug}}');
        $.ajax({
            url : uri,
            data : {edit: 1},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);

            },
            error: function (res) {
                notify('Ajax error.','danger');
                console.log(res);
            }
        })
    })
    function clicks(id){
        btn = $('#'+id);
        load_modal2(btn);
        uri = "{{route('dashboard.employee.matrix','slug')}}";
        uri = uri.replace('slug','{{$employee->slug}}');
        $.ajax({
            url : uri,
            data : {edit: 1},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);

            },
            error: function (res) {
                notify('Ajax error.','danger');
                console.log(res);
            }
        })
    }
</script>
@endsection

