@php($rand = \Illuminate\Support\Str::random(15))
@extends('layouts.modal-content',['form_id'=>'edit_matrix_form_'.$rand,'slug'=> $employee->slug])

@section('modal-header')
{{$employee->lastname}},{{$employee->firstname}} - Edit Matrix
@endsection

@section('modal-body')

    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Education
    </p>
    <div class="row">
        <ol>
            <li> Bachelor's Degree Graduate
                {!! __form::textbox(
                   '12 educ_bachelors_degree', 'educ_bachelors_degree', 'number', '<code>(Max Score : 5)</code>', 'Score', old('educ_bachelors_degree') ? old('educ_bachelors_degree') : optional($employee->employeeMatrix)->educ_bachelors_degree, $errors->has('educ_bachelors_degree'), $errors->first('educ_bachelors_degree'), 'step="0.01" max="5.00" min="0"'
               ) !!}
            </li>
            <li>College Undergraduate
                <div class="col-md-12">
                    {!! __form::textbox(
                      '6 educ_undergrad_bachelor_units_earned', 'educ_undergrad_bachelor_units_earned', 'number', 'Units Earned <code>(Max Score : 160)</code>', 'Units Earned', old('educ_undergrad_bachelor_units_earned') ? old('educ_undergrad_bachelor_units_earned') : optional($employee->employeeMatrix)->educ_undergrad_bachelor_units_earned, $errors->has('educ_undergrad_bachelor_units_earned'), $errors->first('educ_undergrad_bachelor_units_earned'), 'step="1" max="160" min="0"'
                   ) !!}

                    {!! __form::textbox(
                      '6 educ_undergrad_bachelor', 'educ_undergrad_bachelor', 'number', 'Final Computation <code>(Max Score : 5)</code>', 'Score', old('educ_undergrad_bachelor') ? old('educ_undergrad_bachelor') : optional($employee->employeeMatrix)->educ_undergrad_bachelor, $errors->has('educ_undergrad_bachelor'), $errors->first('educ_undergrad_bachelor'), 'step="0.01" max="5.00" min="0"'
                   ) !!}

                </div>
            </li>
            <li>Master's Degree Graduate
                {!! __form::textbox(
                   '12 educ_masters_degree', 'educ_masters_degree', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_masters_degree') ? old('educ_masters_degree') : optional($employee->employeeMatrix)->educ_masters_degree, $errors->has('educ_masters_degree'), $errors->first('educ_masters_degree'), 'step="any"'
               ) !!}
            </li>
            <li>Doctoral Degree Graduate
                {!! __form::textbox(
                   '12 educ_doctoral_degree', 'educ_doctoral_degree', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_doctoral_degree') ? old('educ_doctoral_degree') : optional($employee->employeeMatrix)->educ_doctoral_degree, $errors->has('educ_doctoral_degree'), $errors->first('educ_doctoral_degree'), 'step="any"'
               ) !!}
            </li>
            <li>Undergraduate Masteral/Doctoral</code>)
                <div class="col-md-12">
                    {!! __form::textbox(
                      '6 educ_undergrad_masteral_units_earned', 'educ_undergrad_masteral_units_earned', 'number', 'Units Earned <code>(Max Score : 42)</code>', 'Units Earned', old('educ_undergrad_masteral_units_earned') ? old('educ_undergrad_masteral_units_earned') : optional($employee->employeeMatrix)->educ_undergrad_masteral_units_earned, $errors->has('educ_undergrad_masteral_units_earned'), $errors->first('educ_undergrad_masteral_units_earned'), 'step="any"'
                   ) !!}

                    {!! __form::textbox(
                      '6 educ_undergrad_masteral', 'educ_undergrad_masteral', 'number', 'Final Computation <code>(Max Score : 1)</code>', 'Score', old('educ_undergrad_masteral') ? old('educ_undergrad_masteral') : optional($employee->employeeMatrix)->educ_undergrad_masteral, $errors->has('educ_undergrad_masteral'), $errors->first('educ_undergrad_masteral'), 'step="any"'
                   ) !!}
                </div>
            </li>
            <li>Graduate Certificate Course
                {!! __form::textbox(
                   '12 educ_grad_certificate_course', 'educ_grad_certificate_course', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_grad_certificate_course') ? old('educ_grad_certificate_course') : optional($employee->employeeMatrix)->educ_grad_certificate_course, $errors->has('educ_grad_certificate_course'), $errors->first('educ_grad_certificate_course'), 'step="any"'
               ) !!}
            </li>
            <li>Honors / Awards Recieved / Distinctions:
                <ul>
                    <li>Summa Cum Laude
                        {!! __form::textbox(
                           '12 educ_distinctions_summa_cum_laude', 'educ_distinctions_summa_cum_laude', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_summa_cum_laude') ? old('educ_distinctions_summa_cum_laude') : optional($employee->employeeMatrix)->educ_distinctions_summa_cum_laude, $errors->has('educ_distinctions_summa_cum_laude'), $errors->first('educ_distinctions_summa_cum_laude'), 'step="any"'
                       ) !!}
                    </li>
                    <li>Magna Cum Laude
                        {!! __form::textbox(
                           '12 educ_distinctions_magna_cum_laude', 'educ_distinctions_magna_cum_laude', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_distinctions_magna_cum_laude') ? old('educ_distinctions_magna_cum_laude') : optional($employee->employeeMatrix)->educ_distinctions_magna_cum_laude, $errors->has('educ_distinctions_magna_cum_laude'), $errors->first('educ_distinctions_magna_cum_laude'), 'step="any"'
                       ) !!}
                    </li>
                    <li>Cum Laude / With Honors
                        {!! __form::textbox(
                           '12 educ_distinctions_cum_laude', 'educ_distinctions_cum_laude', 'number', '<code>(Max Score : 1)</code>', 'Score', old('educ_distinctions_cum_laude') ? old('educ_distinctions_cum_laude') : optional($employee->employeeMatrix)->educ_distinctions_cum_laude, $errors->has('educ_distinctions_cum_laude'), $errors->first('educ_distinctions_cum_laude'), 'step="any"'
                       ) !!}
                    </li>
                    <li>Presidential Awardee
                        {!! __form::textbox(
                           '12 educ_distinctions_pres_awardee', 'educ_distinctions_pres_awardee', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_pres_awardee') ? old('educ_distinctions_pres_awardee') : optional($employee->employeeMatrix)->educ_distinctions_pres_awardee, $errors->has('educ_distinctions_pres_awardee'), $errors->first('educ_distinctions_pres_awardee'), 'step="any"'
                       ) !!}
                    </li>
                    <li>CSC / SRA / DA Awardee
                        {!! __form::textbox(
                           '12 educ_distinctions_csc_sra_da_awardee', 'educ_distinctions_csc_sra_da_awardee', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_csc_sra_da_awardee') ? old('educ_distinctions_csc_sra_da_awardee') : optional($employee->employeeMatrix)->educ_distinctions_csc_sra_da_awardee, $errors->has('educ_distinctions_csc_sra_da_awardee'), $errors->first('educ_distinctions_csc_sra_da_awardee'), 'step="any"'
                       ) !!}
                    </li>
                    <li>Top 10 government licensure administered exams
                        {!! __form::textbox(
                           '12 educ_distinctions_top_gov_exam', 'educ_distinctions_top_gov_exam', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_top_gov_exam') ? old('educ_distinctions_top_gov_exam') : optional($employee->employeeMatrix)->educ_distinctions_top_gov_exam, $errors->has('educ_distinctions_top_gov_exam'), $errors->first('educ_distinctions_top_gov_exam'), 'step="any"'
                       ) !!}
                    </li>
                </ul>
            </li>
        </ol>
    </div>


    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Experience
    </p>

    <div class="row">
        {!! __form::textbox(
              '4 experience_years', 'experience_years', 'number', 'No. of years', 'Score', old('experience_years') ? old('experience_years') : optional($employee->employeeMatrix)->experience_years, $errors->has('experience_years'), $errors->first('experience_years'), 'step="any"'
          ) !!}

        {!! __form::textbox(
           '4 experience_req_years', 'experience_req_years', 'number', 'Required no. of years', 'Score', old('experience_req_years') ? old('experience_req_years') : optional($employee->employeeMatrix)->experience_req_years, $errors->has('experience_req_years'), $errors->first('experience_req_years'), 'step="any"'
       ) !!}

        {!! __form::textbox(
           '4 experience', 'experience', 'number', 'Final Computation <code>(Max: 20)</code>', 'Score', old('experience') ? old('experience') : optional($employee->employeeMatrix)->experience, $errors->has('experience'), $errors->first('experience'), 'step="any"'
       ) !!}
    </div>

    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Training
    </p>

    <div class="row">
        {!! __form::textbox(
               '4 training_no', 'training_no', 'number', 'No. of trainings', 'Score', old('training_no') ? old('training_no') : optional($employee->employeeMatrix)->training_no, $errors->has('training_no'), $errors->first('training_no'), 'step="any"'
           ) !!}

        {!! __form::textbox(
           '4 training_req_no', 'training_req_no', 'number', 'Required no. of trainings', 'Score', old('training_req_no') ? old('training_req_no') : optional($employee->employeeMatrix)->training_req_no, $errors->has('training_req_no'), $errors->first('training_req_no'), 'step="any"'
       ) !!}

        {!! __form::textbox(
           '4 training', 'training', 'number', 'Final Computation<code>(Max : 10)</code>', 'Score', old('training') ? old('training') : optional($employee->employeeMatrix)->training, $errors->has('training'), $errors->first('training'), 'step="any"'
       ) !!}
    </div>

    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Eligibility
    </p>

    <div class="row">
        {!! __form::textbox(
           '12 eligibility', 'eligibility', 'number', '<code>(Max Score : 5)</code>', 'Score', old('eligibility') ? old('eligibility') : optional($employee->employeeMatrix)->eligibility, $errors->has('eligibility'), $errors->first('eligibility'), 'step="any"'
       ) !!}
    </div>

    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Performance
    </p>

    <div class="row">
        {!! __form::textbox(
          '12 performance', 'performance', 'number', '<code>(Max Score : 20)</code>', 'Score', old('performance') ? old('performance') : optional($employee->employeeMatrix)->performance, $errors->has('performance'), $errors->first('performance'), 'step="any"'
      ) !!}
    </div>

    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Behavioral Events, Interview, Assesment (BEIA), Work Attitude
    </p>

    <div class="row">
        {!! __form::textbox(
              '6 behavior_point_score', 'behavior_point_score', 'number', 'Point Score <code>(Max Score : 5)</code>', 'Point Score', old('behavior_point_score') ? old('behavior_point_score') : optional($employee->employeeMatrix)->behavior_point_score, $errors->has('behavior_point_score'), $errors->first('behavior_point_score'), 'step="any"'
           ) !!}

        {!! __form::textbox(
          '6 behavior', 'behavior', 'number', 'Final Computation <code>(Max Score : 13)</code>', 'Score', old('behavior') ? old('behavior') : optional($employee->employeeMatrix)->behavior, $errors->has('behavior'), $errors->first('behavior'), 'step="any"'
       ) !!}
    </div>

    <p class="page-header-sm text-left on-well text-info" style=" border-bottom: 1px solid #efefef;">
        Psychological and Mental Aptitude Tests
    </p>

    <div class="row">
        {!! __form::textbox(
              '6 psycho_test_point_score', 'psycho_test_point_score', 'number', 'Point Score <code>(Max Score : 100)</code>', 'Point Score', old('psycho_test_point_score') ? old('psycho_test_point_score') : optional($employee->employeeMatrix)->psycho_test_point_score, $errors->has('psycho_test_point_score'), $errors->first('psycho_test_point_score'), 'step="any"'
           ) !!}

        {!! __form::textbox(
          '6 psycho_test', 'psycho_test', 'number', 'Final Computation <code>(Max Score : 5)</code>', 'Score', old('psycho_test') ? old('psycho_test') : optional($employee->employeeMatrix)->psycho_test, $errors->has('psycho_test'), $errors->first('psycho_test'), 'step="any"'
       ) !!}
    </div>
</div>
@endsection

@section('modal-footer')
    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#edit_matrix_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        loading_btn(form);
        uri = "{{route('dashboard.employee.matrix_update','slug')}}";
        uri = uri.replace('slug',form.attr('data'));
        $.ajax({
            url : uri,
            data : form.serialize(),
            type: 'POST',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
               succeed(form,true,true);
               $("#matrix_modal .modal-body").html('<div class="load">\n' +
                   '        <center>\n' +
                   '            <img style="width: 100px" src="http://localhost:8001/images/loader.gif">\n' +
                   '        </center>\n' +
                   '    </div>');
                $("#matrix_modal .modal-body .load").fadeOut(function () {
                    $("#matrix_modal .modal-body").html(res);
                });

            },
            error: function (res) {
                errored(form,res);
                console.log(res);
            }
        })
    })
</script>
@endsection

