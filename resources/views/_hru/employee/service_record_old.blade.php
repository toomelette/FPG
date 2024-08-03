<?php

  $table_sessions = [ 
                      Session::get('EMPLOYEE_SR_UPDATE_SUCCESS_SLUG'),
                      Session::get('EMPLOYEE_SR_CREATE_SUCCESS_SLUG'),
                    ];

?>

@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Edit Employee Service Record</h1>
      <div class="pull-right" style="margin-top: -25px;">
        {!! __html::back_button(['dashboard.employee.index']) !!}
      </div>
  </section>

  <section class="content" id="pjax-container">


    {{-- Form --}}
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Create Form</h3>
          <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
          </div> 
        </div>

        <form data-pjax role="form" method="POST" autocomplete="off" action="{{ route('dashboard.employee.service_record_store', $employee->slug) }}">

          @csrf

          <div class="box-body">

            {!! __form::textbox(
               '2', 'sequence_no', 'text', 'Seq No. *', 'Seq No.', old('sequence_no'), $errors->has('sequence_no'), $errors->first('sequence_no'), ''
            ) !!}

            {!! __form::textbox(
               '5', 'date_from', 'text', 'Date From *', 'Date From', old('date_from'), $errors->has('date_from'), $errors->first('date_from'), ''
            ) !!}

            {!! __form::textbox(
               '5', 'date_to', 'text', 'Date To *', 'Date To', old('date_to'), $errors->has('date_to'), $errors->first('date_to'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
               '6', 'position', 'text', 'Position *', 'Position', old('position'), $errors->has('position'), $errors->first('position'), 'data-transform="uppercase"'
            ) !!}

            {!! __form::textbox(
               '6', 'appointment_status', 'text', 'Appointment Status *', 'Appointment Status', old('appointment_status'), $errors->has('appointment_status'), $errors->first('appointment_status'), 'data-transform="uppercase"'
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox_numeric(
              '8', 'salary', 'text', 'Salary *', 'Salary', old('salary'), $errors->has('salary'), $errors->first('salary'), ''
            ) !!}

            {!! __form::textbox(
               '4', 'mode_of_payment', 'text', 'Mode of Payment *', 'Mode of Payment', old('mode_of_payment'), $errors->has('mode_of_payment'), $errors->first('mode_of_payment'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
               '4', 'station', 'text', 'Station *', 'Station', old('station'), $errors->has('station'), $errors->first('station'), ''
            ) !!}

            {!! __form::textbox(
               '4', 'gov_serve', 'text', 'Government Serve', 'Government Serve', old('gov_serve'), $errors->has('gov_serve'), $errors->first('gov_serve'), ''
            ) !!}

            {!! __form::textbox(
               '4', 'psc_serve', 'text', 'PSC Serve', 'PSC Serve', old('psc_serve'), $errors->has('psc_serve'), $errors->first('psc_serve'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
               '4', 'lwp', 'text', 'LWP', 'LWP', old('lwp'), $errors->has('lwp'), $errors->first('lwp'), ''
            ) !!}

            {!! __form::textbox(
               '4', 'spdate', 'text', 'SP Date', 'SP Date', old('spdate'), $errors->has('spdate'), $errors->first('spdate'), ''
            ) !!}

            {!! __form::textbox(
               '4', 'status', 'text', 'Status', 'Status', old('status'), $errors->has('status'), $errors->first('status'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
               '12', 'remarks', 'text', 'Remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), ''
            ) !!}


          </div>

          <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
          </div>

        </form>
      </div>
    </div>






    {{-- Table --}}
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Service Records</h3> 
          <div class="box-tools">
            <a href="#" id="print_service_record" data-url="{{ route('dashboard.employee.service_record_print', $employee->slug) }}" class="btn btn-sm btn-default">
              <i class="fa fa-print"></i> Print
            </a>
          </div>
        </div>

        <div class="box-body">
          @if($errors->all())
            <ul style="line-height: 10px;">
              @foreach ($errors->all() as $data)
                <li><p class="text-danger">{{ $data }}</p></li>
              @endforeach
            </ul>
          @endif
          <table class="table table-hover">
            <tr>
              <th>Seq #</th>
              <th>Date From</th>
              <th>Date To</th>
              <th>Position</th>
              <th>Appointment Status</th>
              <th>Salary</th>
              <th>Action</th>
            </tr>
            @foreach($employee_service_records as $data) 
              <tr 
                {!! __html::table_highlighter( $data->slug, $table_sessions) !!} 
                {!! old('e_slug') == $data->slug ? 'style="background-color: #F5B7B1;"' : '' !!}
              >
                <td>{{ $data->sequence_no }}</td>
                <td>{{ $data->date_from }}</td>
                <td>{{ $data->date_to }}</td>
                <td>{{ $data->position }}</td>
                <td>{{ $data->appointment_status }}</td>
                <td>{{ number_format($data->salary, 2) .' / '. $data->mode_of_payment }}</td>
                <td>
                  <div class="btn-group">
                    <a href="#" id="sr_update_btn" es="{{ $data->slug }}" data-url="{{ route('dashboard.employee.service_record_update', [$employee->slug, $data->slug]) }}" class="btn btn-sm btn-default">
                      <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <a href="#" id="sr_delete_btn" data-url="{{ route('dashboard.employee.service_record_destroy', $data->slug) }}" class="btn btn-sm btn-default">
                      <i class="fa  fa-trash-o"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </table>

          @if($employee->employeeServiceRecord->isEmpty())
            <div style="padding :5px;">
              <center><h4>No Records found!</h4></center>
            </div>
          @endif

        </div>

      </div>
    </div>

    

  </section>

@endsection





@section('modals')
  

  {{-- Delete --}}
  {!! __html::modal_delete('sr_delete') !!}


  {{-- Update --}}
  <div class="modal fade bs-example-modal-lg" id="sr_update" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body" id="sr_update_body">
          <form data-pjax id="sr_update_form" method="POST" autocomplete="off">

            <div class="row">
                
              @csrf
              <input name="_method" value="PUT" type="hidden">

              <input name="e_slug" id="e_slug"  type="hidden">

              {!! __form::textbox(
               '2', 'e_sequence_no', 'text', 'Seq No. *', 'Seq No.', old('e_sequence_no'), $errors->has('e_sequence_no'), $errors->first('e_sequence_no'), ''
              ) !!}

              {!! __form::textbox(
                 '5', 'e_date_from', 'text', 'Date From *', 'Date From', old('e_date_from'), $errors->has('e_date_from'), $errors->first('e_date_from'), ''
              ) !!}

              {!! __form::textbox(
                 '5', 'e_date_to', 'text', 'Date To *', 'Date To', old('e_date_to'), $errors->has('e_date_to'), $errors->first('e_date_to'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                 '6', 'e_position', 'text', 'Position *', 'Position', old('e_position'), $errors->has('e_position'), $errors->first('e_position'), 'data-transform="uppercase"'
              ) !!}

              {!! __form::textbox(
                 '6', 'e_appointment_status', 'text', 'Appointment Status *', 'Appointment Status', old('e_appointment_status'), $errors->has('e_appointment_status'), $errors->first('e_appointment_status'), 'data-transform="uppercase"'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '8', 'e_salary', 'text', 'Salary *', 'Salary', old('e_salary'), $errors->has('e_salary'), $errors->first('e_salary'), ''
              ) !!}

              {!! __form::textbox(
                 '4', 'e_mode_of_payment', 'text', 'Mode of Payment *', 'Mode of Payment', old('e_mode_of_payment'), $errors->has('e_mode_of_payment'), $errors->first('e_mode_of_payment'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                 '4', 'e_station', 'text', 'Station *', 'Station', old('e_station'), $errors->has('e_station'), $errors->first('e_station'), ''
              ) !!}

              {!! __form::textbox(
                 '4', 'e_gov_serve', 'text', 'Government Serve', 'Government Serve', old('e_gov_serve'), $errors->has('e_gov_serve'), $errors->first('e_gov_serve'), ''
              ) !!}

              {!! __form::textbox(
                 '4', 'e_psc_serve', 'text', 'PSC Serve', 'PSC Serve', old('e_psc_serve'), $errors->has('e_psc_serve'), $errors->first('e_psc_serve'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                 '4', 'e_lwp', 'text', 'LWP', 'LWP', old('e_lwp'), $errors->has('e_lwp'), $errors->first('e_lwp'), ''
              ) !!}

              {!! __form::textbox(
                 '4', 'e_spdate', 'text', 'SP Date', 'SP Date', old('e_spdate'), $errors->has('e_spdate'), $errors->first('e_spdate'), ''
              ) !!}

              {!! __form::textbox(
                 '4', 'e_status', 'text', 'Status', 'Status', old('e_status'), $errors->has('e_status'), $errors->first('e_status'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                 '12', 'e_remarks', 'text', 'Remarks', 'Remarks', old('e_remarks'), $errors->has('e_remarks'), $errors->first('e_remarks'), ''
              ) !!}

            </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>
        </form>
      </div>
    </div>
  </div>



  {{-- Print Modal --}}
  <div class="modal fade" id="print_sr_modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Please set Signatories!</h4>
        </div>
        <form id="print_sr_form" method="GET" target="_blank">
          <div class="modal-body">
            {!! __form::textbox(
               '6', 'pn', 'text', 'Prepared By:', 'Prepared By', old('pn'), $errors->has('pn'), $errors->first('pn'), 'data-transform="uppercase"'
            ) !!}

            {!! __form::textbox(
               '6', 'pp', 'text', 'Prepared Position:', 'Prepared Position', old('pp'), $errors->has('pp'), $errors->first('pp'), 'data-transform="uppercase"'
            ) !!}

            {!! __form::textbox(
               '6', 'cn', 'text', 'Certified By:', 'Certified By', old('cn'), $errors->has('cn'), $errors->first('cn'), 'data-transform="uppercase"'
            ) !!}

            {!! __form::textbox(
               '6', 'cp', 'text', 'Certified Position:', 'Certified Position', old('cp'), $errors->has('cp'), $errors->first('cp'), 'data-transform="uppercase"'
            ) !!} 

          </div>
          <div class="modal-footer" style="overflow: hidden;">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Print</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  
@endsection 





@section('scripts')

  <script type="text/javascript">

    // Delete Button Action
    $(document).on("click", "#sr_delete_btn", function () {
      $("#sr_delete").modal("show");
      $("#delete_body #form").attr("action", $(this).data("url"));
      $("#delete_body #form").attr("data-pjax", '');
      $(this).val("");
    });


    // Delete Form Action
    $(document).on("submit", "#delete_body #form", function () {
        $('#sr_delete').delay(100).fadeOut(100);
       setTimeout(function(){
          $('#sr_delete').modal("hide");
       }, 200);
    });


    // Update Button Action
    $(document).on("click", "#sr_update_btn", function () {

      var slug = $(this).attr("es");

      $("#sr_update").modal("show");
      $("#sr_update_body #sr_update_form").attr("action", $(this).data("url"));

      // Price Format
      $(".priceformat").priceFormat({
          prefix: "",
          thousandsSeparator: ",",
          clearOnEmpty: true,
          allowNegative: true
      });

      $.ajax({
        headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
          url: "/api/employee/serviceRecord/"+slug+"/edit",
          type: "GET",
          dataType: "json",
          success:function(data) {       
            
            $.each(data, function(key, value) {
              $("#sr_update_form #e_slug").val(value.slug);
              $("#sr_update_form #e_sequence_no").val(value.sequence_no);
              $("#sr_update_form #e_date_from").val(value.date_from);
              $("#sr_update_form #e_date_to").val(value.date_to);
              $("#sr_update_form #e_position").val(value.position);
              $("#sr_update_form #e_appointment_status").val(value.appointment_status);
              $("#sr_update_form #e_salary").val(value.salary);
              $("#sr_update_form #e_mode_of_payment").val(value.mode_of_payment);
              $("#sr_update_form #e_station").val(value.station);
              $("#sr_update_form #e_gov_serve").val(value.gov_serve);
              $("#sr_update_form #e_psc_serve").val(value.psc_serve);
              $("#sr_update_form #e_lwp").val(value.lwp);
              $("#sr_update_form #e_spdate").val(value.spdate);
              $("#sr_update_form #e_status").val(value.status);
              $("#sr_update_form #e_remarks").val(value.remarks);
            });

          }
      });

    });


    // Update Form Action
    $(document).on("submit", "#sr_update_body #sr_update_form", function () {
      $('#sr_update').delay(50).fadeOut(50);
      setTimeout(function(){
        $('#sr_update').modal("hide");  
      }, 100);
    });


    {{-- CALL PRINT SR MODAL --}}
    $(document).on("click", "#print_service_record", function () {
        $("#print_sr_modal").modal("show");
        $("#print_sr_form").attr("action", $(this).data("url"));
    });



  </script> 
    
@endsection