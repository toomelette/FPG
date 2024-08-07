<?php

  $table_sessions = [ 
                      Session::get('PS_UPDATE_SUCCESS_SLUG'),
                    ];

  $appended_requests = [
                        'q'=> Request::get('q'), 
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                        'e' => Request::get('e'),
                        
                        'emp' => Request::get('emp'),
                        'df' => Request::get('df'), 
                        'dt' => Request::get('dt'), 
                      ];

?>



@extends('layouts.admin-master')



@section('content')
    
  <section class="content-header">
      <h1>Permission Slip List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.permission_slip.index') }}">

    {{-- Advance Filters --}}
    {!! __html::filter_open() !!}
        
      {!! __form::select_dynamic_for_filter(
        '3', 'emp', 'Employee', old('emp'), $global_employees_all, 'employee_no', 'fullname', 'submit_ps_filter', 'select2', 'style="width:100%;"'
      ) !!}

      <div class="col-md-12" style="margin-right: 100px;"></div>

      <div class="col-md-12 no-padding">
        
        <h5>Date Filter : </h5>

        {!! __form::datepicker('3', 'df',  'From', old('df'), '', '') !!}

        {!! __form::datepicker('3', 'dt',  'To', old('dt'), '', '') !!}

        <button type="submit" class="btn btn-primary" style="margin:25px;">Filter Date <i class="fa fa-fw fa-arrow-circle-right"></i></button>

      </div>


    {!! __html::filter_close('submit_ps_filter') !!}


    <div class="box" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.permission_slip.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('ps_id', 'Control No.')</th>
            <th>@sortablelink('employee.fullname', 'Employee')</th>
            <th>@sortablelink('date', 'Date')</th>
            <th>@sortablelink('time_out', 'Time Out')</th>
            <th>@sortablelink('time_in', 'Time In')</th>
            <th>@sortablelink('with_ps', 'With PS')</th>
            <th style="width: 150px">Action</th>
          </tr>
          @foreach($permission_slips as $data) 
            <tr {!! __html::table_highlighter( $data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->ps_id }}</td>
              <td id="mid-vert">{{ empty($data->employee) ? '' : $data->employee->fullname }}</td>
              <td id="mid-vert">{{ Helper::dateFormat($data->date) }}</td>
              <td id="mid-vert">{{ date('h:i A', strtotime($data->time_out)) }}</td>
              <td id="mid-vert">{{ date('h:i A', strtotime($data->time_in)) }}</td>
              <td id="mid-vert">{{ $data->with_ps == 1 ? 'YES' : 'NO' }}</td>

              <td id="mid-vert"> 
                <select id="action" class="form-control input-md">
                  <option value="">Select</option>
                  <option data-type="1" data-url="{{ route('dashboard.permission_slip.show', $data->slug) }}">Details</option>
                  <option data-type="1" data-url="{{ route('dashboard.permission_slip.edit', $data->slug) }}">Edit</option>
                  <option data-type="0" data-action="delete" data-url="{{ route('dashboard.permission_slip.destroy', $data->slug) }}">Delete</option>
                </select>
              </td>

            </tr>
            @endforeach
        </table>
      </div>

      @if($permission_slips->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($permission_slips) !!}
        {!! $permission_slips->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
      </div>

    </div>

  </section>

@endsection






@section('modals')

  {!! __html::modal_delete('ps_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::modal_confirm_delete_caller('ps_delete') !!}

    {{-- PS DELETE TOAST --}}
    @if(Session::has('PS_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('PS_UPDATE_SUCCESS')) !!}
    @endif

    {{-- PS DELETE TOAST --}}
    @if(Session::has('PS_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('PS_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection