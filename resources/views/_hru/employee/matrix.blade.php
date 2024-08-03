@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Employee Matrix</h1>
	    <div class="pull-right" style="margin-top: -25px;">
	      {!! __html::back_button(['dashboard.employee.matrix_show']) !!}
	    </div>
  </section>

  <section class="content">

    <div class="box">
    
		<div class="box-header with-border">
			<h3 class="box-title">Form</h3>
			<div class="pull-right">
			    <code>Fields with asterisks(*) are required</code>
			</div> 
		</div>

        <form role="form" method="POST" autocomplete="off" action="{{ route('dashboard.employee.matrix_update', $employee->slug) }}">

	    <div class="box-body">
	 
	      	@csrf    
	      	
	      	<div class="col-md-8">

	          	<h4>Education</h4>

	          	<ol>	
	          		<li> Bachelor's Degree Graduate

	          			{!! __form::textbox(
			             	'12', 'educ_bachelors_degree', 'number', '<code>(Max Score : 5)</code>', 'Score', old('educ_bachelors_degree') ? old('educ_bachelors_degree') : optional($employee->employeeMatrix)->educ_bachelors_degree, $errors->has('educ_bachelors_degree'), $errors->first('educ_bachelors_degree'), 'step="any"'
			         	) !!} 

			        </li>	

	          		<li>College Undergraduate
	          			
	          			<div class="col-md-12">
	          			
		          			{!! __form::textbox(
				            	'6', 'educ_undergrad_bachelor_units_earned', 'number', 'Units Earned <code>(Max Score : 160)</code>', 'Units Earned', old('educ_undergrad_bachelor_units_earned') ? old('educ_undergrad_bachelor_units_earned') : optional($employee->employeeMatrix)->educ_undergrad_bachelor_units_earned, $errors->has('educ_undergrad_bachelor_units_earned'), $errors->first('educ_undergrad_bachelor_units_earned'), 'step="any"'
				         	) !!} 

		          			{!! __form::textbox(
				            	'6', 'educ_undergrad_bachelor', 'number', 'Final Computation <code>(Max Score : 5)</code>', 'Score', old('educ_undergrad_bachelor') ? old('educ_undergrad_bachelor') : optional($employee->employeeMatrix)->educ_undergrad_bachelor, $errors->has('educ_undergrad_bachelor'), $errors->first('educ_undergrad_bachelor'), 'step="any"'
				         	) !!} 
	          					
	          			</div>

			        </li>	

	          		<li>Master's Degree Graduate

	          			{!! __form::textbox(
			             	'12', 'educ_masters_degree', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_masters_degree') ? old('educ_masters_degree') : optional($employee->employeeMatrix)->educ_masters_degree, $errors->has('educ_masters_degree'), $errors->first('educ_masters_degree'), 'step="any"'
			         	) !!} 

	          		</li>

	          		<li>Doctoral Degree Graduate

	          			{!! __form::textbox(
			             	'12', 'educ_doctoral_degree', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_doctoral_degree') ? old('educ_doctoral_degree') : optional($employee->employeeMatrix)->educ_doctoral_degree, $errors->has('educ_doctoral_degree'), $errors->first('educ_doctoral_degree'), 'step="any"'
			         	) !!} 

	          		</li>

	          		<li>Undergraduate Masteral/Doctoral</code>)
	          			
	          			<div class="col-md-12">
	          			
		          			{!! __form::textbox(
				            	'6', 'educ_undergrad_masteral_units_earned', 'number', 'Units Earned <code>(Max Score : 42)</code>', 'Units Earned', old('educ_undergrad_masteral_units_earned') ? old('educ_undergrad_masteral_units_earned') : optional($employee->employeeMatrix)->educ_undergrad_masteral_units_earned, $errors->has('educ_undergrad_masteral_units_earned'), $errors->first('educ_undergrad_masteral_units_earned'), 'step="any"'
				         	) !!} 

		          			{!! __form::textbox(
				            	'6', 'educ_undergrad_masteral', 'number', 'Final Computation <code>(Max Score : 1)</code>', 'Score', old('educ_undergrad_masteral') ? old('educ_undergrad_masteral') : optional($employee->employeeMatrix)->educ_undergrad_masteral, $errors->has('educ_undergrad_masteral'), $errors->first('educ_undergrad_masteral'), 'step="any"'
				         	) !!} 
	          					
	          			</div>

	          		</li>

	          		<li>Graduate Certificate Course

	          			{!! __form::textbox(
			             	'12', 'educ_grad_certificate_course', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_grad_certificate_course') ? old('educ_grad_certificate_course') : optional($employee->employeeMatrix)->educ_grad_certificate_course, $errors->has('educ_grad_certificate_course'), $errors->first('educ_grad_certificate_course'), 'step="any"'
			         	) !!} 

	          		</li>

	          		<li>Honors / Awards Recieved / Distinctions:
	          			<ul>	
	          				<li>Summa Cum Laude

			          			{!! __form::textbox(
					             	'12', 'educ_distinctions_summa_cum_laude', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_summa_cum_laude') ? old('educ_distinctions_summa_cum_laude') : optional($employee->employeeMatrix)->educ_distinctions_summa_cum_laude, $errors->has('educ_distinctions_summa_cum_laude'), $errors->first('educ_distinctions_summa_cum_laude'), 'step="any"'
					         	) !!} 

	          				</li>

	          				<li>Magna Cum Laude

			          			{!! __form::textbox(
					             	'12', 'educ_distinctions_magna_cum_laude', 'number', '<code>(Max Score : 2)</code>', 'Score', old('educ_distinctions_magna_cum_laude') ? old('educ_distinctions_magna_cum_laude') : optional($employee->employeeMatrix)->educ_distinctions_magna_cum_laude, $errors->has('educ_distinctions_magna_cum_laude'), $errors->first('educ_distinctions_magna_cum_laude'), 'step="any"'
					         	) !!} 

	          				</li>

	          				<li>Cum Laude / With Honors

			          			{!! __form::textbox(
					             	'12', 'educ_distinctions_cum_laude', 'number', '<code>(Max Score : 1)</code>', 'Score', old('educ_distinctions_cum_laude') ? old('educ_distinctions_cum_laude') : optional($employee->employeeMatrix)->educ_distinctions_cum_laude, $errors->has('educ_distinctions_cum_laude'), $errors->first('educ_distinctions_cum_laude'), 'step="any"'
					         	) !!} 

	          				</li>

	          				<li>Presidential Awardee

			          			{!! __form::textbox(
					             	'12', 'educ_distinctions_pres_awardee', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_pres_awardee') ? old('educ_distinctions_pres_awardee') : optional($employee->employeeMatrix)->educ_distinctions_pres_awardee, $errors->has('educ_distinctions_pres_awardee'), $errors->first('educ_distinctions_pres_awardee'), 'step="any"'
					         	) !!} 

	          				</li>

	          				<li>CSC / SRA / DA Awardee

			          			{!! __form::textbox(
					             	'12', 'educ_distinctions_csc_sra_da_awardee', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_csc_sra_da_awardee') ? old('educ_distinctions_csc_sra_da_awardee') : optional($employee->employeeMatrix)->educ_distinctions_csc_sra_da_awardee, $errors->has('educ_distinctions_csc_sra_da_awardee'), $errors->first('educ_distinctions_csc_sra_da_awardee'), 'step="any"'
					         	) !!} 

	          				</li>

	          				<li>Top 10 government licensure administered exams

			          			{!! __form::textbox(
					             	'12', 'educ_distinctions_top_gov_exam', 'number', '<code>(Max Score : 3)</code>', 'Score', old('educ_distinctions_top_gov_exam') ? old('educ_distinctions_top_gov_exam') : optional($employee->employeeMatrix)->educ_distinctions_top_gov_exam, $errors->has('educ_distinctions_top_gov_exam'), $errors->first('educ_distinctions_top_gov_exam'), 'step="any"'
					         	) !!} 

	          				</li>

	          			</ul>
	          		</li>
	          	</ol>  		

	          	<h4>Experience</h4>

	          	<div class="col-md-12">

		  			{!! __form::textbox(
		             	'4', 'experience_years', 'number', 'No. of years', 'Score', old('experience_years') ? old('experience_years') : optional($employee->employeeMatrix)->experience_years, $errors->has('experience_years'), $errors->first('experience_years'), 'step="any"'
		         	) !!} 

		  			{!! __form::textbox(
		             	'4', 'experience_req_years', 'number', 'Required no. of years', 'Score', old('experience_req_years') ? old('experience_req_years') : optional($employee->employeeMatrix)->experience_req_years, $errors->has('experience_req_years'), $errors->first('experience_req_years'), 'step="any"'
		         	) !!} 

		  			{!! __form::textbox(
		             	'4', 'experience', 'number', 'Final Computation <code>(Max Score : 20)</code>', 'Score', old('experience') ? old('experience') : optional($employee->employeeMatrix)->experience, $errors->has('experience'), $errors->first('experience'), 'step="any"'
		         	) !!} 

	        	</div>

	          	<h4>Training</h4>

	          	<div class="col-md-12">

		  			{!! __form::textbox(
		             	'4', 'training_no', 'number', 'No. of trainings', 'Score', old('training_no') ? old('training_no') : optional($employee->employeeMatrix)->training_no, $errors->has('training_no'), $errors->first('training_no'), 'step="any"'
		         	) !!}

		  			{!! __form::textbox(
		             	'4', 'training_req_no', 'number', 'Required no. of trainings', 'Score', old('training_req_no') ? old('training_req_no') : optional($employee->employeeMatrix)->training_req_no, $errors->has('training_req_no'), $errors->first('training_req_no'), 'step="any"'
		         	) !!}

		  			{!! __form::textbox(
		             	'4', 'training', 'number', 'Final Computation<code>(Max Score : 10)</code>', 'Score', old('training') ? old('training') : optional($employee->employeeMatrix)->training, $errors->has('training'), $errors->first('training'), 'step="any"'
		         	) !!} 

	            </div>

	          	<h4>Eligibility</h4>

	  			{!! __form::textbox(
	             	'12', 'eligibility', 'number', '<code>(Max Score : 5)</code>', 'Score', old('eligibility') ? old('eligibility') : optional($employee->employeeMatrix)->eligibility, $errors->has('eligibility'), $errors->first('eligibility'), 'step="any"'
	         	) !!} 

	          	<h4>Performance</h4>

	  			{!! __form::textbox(
	             	'12', 'performance', 'number', '<code>(Max Score : 20)</code>', 'Score', old('performance') ? old('performance') : optional($employee->employeeMatrix)->performance, $errors->has('performance'), $errors->first('performance'), 'step="any"'
	         	) !!} 

	          	<h4>Behavioral Events, Interview, Assesment (BEIA), Work Attitude</h4>
	          			
	  			<div class="col-md-12">
	  			
	      			{!! __form::textbox(
		            	'6', 'behavior_point_score', 'number', 'Point Score <code>(Max Score : 5)</code>', 'Point Score', old('behavior_point_score') ? old('behavior_point_score') : optional($employee->employeeMatrix)->behavior_point_score, $errors->has('behavior_point_score'), $errors->first('behavior_point_score'), 'step="any"'
		         	) !!} 

	      			{!! __form::textbox(
		            	'6', 'behavior', 'number', 'Final Computation <code>(Max Score : 13)</code>', 'Score', old('behavior') ? old('behavior') : optional($employee->employeeMatrix)->behavior, $errors->has('behavior'), $errors->first('behavior'), 'step="any"'
		         	) !!} 
	  					
	  			</div>

	          	<h4>Psychological and Mental Aptitude Tests</h4>
	          			
	  			<div class="col-md-12">
	  			
	      			{!! __form::textbox(
		            	'6', 'psycho_test_point_score', 'number', 'Point Score <code>(Max Score : 100)</code>', 'Point Score', old('psycho_test_point_score') ? old('psycho_test_point_score') : optional($employee->employeeMatrix)->psycho_test_point_score, $errors->has('psycho_test_point_score'), $errors->first('psycho_test_point_score'), 'step="any"'
		         	) !!} 

	      			{!! __form::textbox(
		            	'6', 'psycho_test', 'number', 'Final Computation <code>(Max Score : 5)</code>', 'Score', old('psycho_test') ? old('psycho_test') : optional($employee->employeeMatrix)->psycho_test, $errors->has('psycho_test'), $errors->first('psycho_test'), 'step="any"'
		         	) !!} 
	  					
	  			</div>

  			</div>


	    </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </div>

      </form>

    </div>

  </section>

@endsection





@section('modals')

  @if(Session::has('EMPLOYEE_MATRIX_UPDATE_SUCCESS'))

    {!! __html::modal_print(
      'emp_matrix_update', '<i class="fa fa-fw fa-check"></i> Saved!', Session::get('EMPLOYEE_MATRIX_UPDATE_SUCCESS'), route('dashboard.employee.matrix_show', Session::get('EMPLOYEE_MATRIX_UPDATE_SUCCESS_SLUG'))
    ) !!}

    
  @endif

@endsection 






@section('scripts')

  <script type="text/javascript">


    @if(Session::has('EMPLOYEE_MATRIX_UPDATE_SUCCESS'))
      $('#emp_matrix_update').modal('show');
    @endif


    // Undergrad Bachelor
    $(document).ready(function(){
	  $("#educ_undergrad_bachelor_units_earned").keyup(function(){
	  	var factored_units = $(this).val() / 160;
	  	var score = factored_units * 5;

	  	if(score > 5){
	  		score = 5;
	  	}

	    $("#educ_undergrad_bachelor").val(score.toFixed(2));
	  });
	});

    $(document).ready(function(){
	  $("#educ_undergrad_bachelor_units_earned").keydown(function(){
	  	var factored_units = $(this).val() / 160;
	  	var score = factored_units * 5;

	  	if(score > 5){
	  		score = 5;
	  	}

	    $("#educ_undergrad_bachelor").val(score.toFixed(2));
	  });
	});




    // Undergrad Masteral
    $(document).ready(function(){
	  $("#educ_undergrad_masteral_units_earned").keyup(function(){
	  	var factored_units = $(this).val() / 42;
	  	var score = factored_units * 1;

	  	if(score > 1){
	  		score = 1;
	  	}

	    $("#educ_undergrad_masteral").val(score.toFixed(2));
	  });
	});

    $(document).ready(function(){
	  $("#educ_undergrad_masteral_units_earned").keydown(function(){
	  	var factored_units = $(this).val() / 42;
	  	var score = factored_units * 1;

	  	if(score > 1){
	  		score = 1;
	  	}

	    $("#educ_undergrad_masteral").val(score.toFixed(2));
	  });
	});



    // Experience Years
    $(document).ready(function(){
	  $("#experience_years").keyup(function(){
	  	var years = $(this).val();
	  	var req_years = $("#experience_req_years").val();
	  	var score = years / req_years * 20;

	  	if(score > 20){
	  		score = 20;
	  	}

	    $("#experience").val(score.toFixed(2));
	  });
	});



    $(document).ready(function(){
	  $("#experience_years").keyup(function(){
	  	var years = $(this).val();
	  	var req_years = $("#experience_req_years").val();
	  	var score = years / req_years * 20;

	  	if(score > 20){
	  		score = 20;
	  	}

	    $("#experience").val(score.toFixed(2));
	  });
	});




    // Experience Required Years
    $(document).ready(function(){
	  $("#experience_req_years").keyup(function(){
	  	var req_years = $(this).val();
	  	var years = $("#experience_years").val();
	  	var score = years / req_years * 20;

	  	if(score > 20){
	  		score = 20;
	  	}

	    $("#experience").val(score.toFixed(2));
	  });
	});


    $(document).ready(function(){
	  $("#experience_req_years").keydown(function(){
	  	var req_years = $(this).val();
	  	var years = $("#experience_years").val();
	  	var score = years / req_years * 20;

	  	if(score > 20){
	  		score = 20;
	  	}

	    $("#experience").val(score.toFixed(2));
	  });
	});



    // No of trainings
    $(document).ready(function(){
	  $("#training_no").keyup(function(){
	  	var trng_no = $(this).val();
	  	var req_trng_no = $("#training_req_no").val();
	  	var score = trng_no / req_trng_no * 10;

	  	if(score > 10){
	  		score = 10;
	  	}

	    $("#training").val(score.toFixed(2));
	  });
	});



    $(document).ready(function(){
	  $("#training_no").keydown(function(){
	  	var trng_no = $(this).val();
	  	var req_trng_no = $("#training_req_no").val();
	  	var score = trng_no / req_trng_no * 10;

	  	if(score > 10){
	  		score = 10;
	  	}

	    $("#training").val(score.toFixed(2));
	  });
	});



    // No of trainings required
    $(document).ready(function(){
	  $("#training_req_no").keyup(function(){
	  	var trng_no = $("#training_no").val();
	  	var req_trng_no = $(this).val();
	  	var score = trng_no / req_trng_no * 10;

	  	if(score > 10){
	  		score = 10;
	  	}

	    $("#training").val(score.toFixed(2));
	  });
	});



    $(document).ready(function(){
	  $("#training_req_no").keydown(function(){
	  	var trng_no = $("#training_no").val();
	  	var req_trng_no = $(this).val();
	  	var score = trng_no / req_trng_no * 10;

	  	if(score > 10){
	  		score = 10;
	  	}

	    $("#training").val(score.toFixed(2));
	  });
	});






    // Behavior Score
    $(document).ready(function(){
	  $("#behavior_point_score").keyup(function(){
	  	var factored_units = $(this).val() / 5;
	  	var score = factored_units * 13;

	  	if(score > 13){
	  		score = 13;
	  	}

	    $("#behavior").val(score.toFixed(2));
	  });
	});

    $(document).ready(function(){
	  $("#behavior_point_score").keydown(function(){
	  	var factored_units = $(this).val() / 5;
	  	var score = factored_units * 13;

	  	if(score > 13){
	  		score = 13;
	  	}

	    $("#behavior").val(score.toFixed(2));
	  });
	});




    // Psycho Test Score
    $(document).ready(function(){
	  $("#psycho_test_point_score").keyup(function(){
	  	var factored_units = $(this).val() / 100;
	  	var score = factored_units * 5;

	  	if(score > 5){
	  		score = 5;
	  	}

	    $("#psycho_test").val(score.toFixed(2));
	  });
	});

    $(document).ready(function(){
	  $("#psycho_test_point_score").keydown(function(){
	  	var factored_units = $(this).val() / 100;
	  	var score = factored_units * 5;

	  	if(score > 5){
	  		score = 5;
	  	}
	  	
	    $("#psycho_test").val(score.toFixed(2));
	  });
	});


  </script> 
    
@endsection