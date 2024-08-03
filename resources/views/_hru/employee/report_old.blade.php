<?php
  
$report_types = [
                'Alphabetical' => 'ALPHA',
                'By Gender' => 'GEN', 
                'By Unit' => 'UNIT',
                'By City (Residential Address)' => 'RES_CITY',
              ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Employee Reports</h1>
  </section>

  <section class="content">




    <div class="box">
    
      <div class="box-header with-border">
        <h3 class="box-title">Employee Reports</h3>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form role="form" method="GET" autocomplete="off" action="{{ route('dashboard.employee.report_generate') }}" target="_blank">

        <div class="box-body">

          {!! __form::select_static(
            '3', 'r_type', 'Type *', old('r_type'), $report_types, $errors->has('r_type'), $errors->first('r_type'), '', ''
          ) !!}

        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-success">Generate <i class="fa fa-fw fa-refresh"></i></button>
        </div>

      </form>

    </div>


  </section>

@endsection