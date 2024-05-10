<?php
   $table_sessions = [
                      Session::get('LC_UPDATE_SUCCESS_SLUG')
                    ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                        'e' => Request::get('e'),

                        'emp'=> Request::get('emp'), 
                        'doc_t'=> Request::get('doc_t'),
                        'leave_t'=> Request::get('leave_t'),
                        'df'=> Request::get('df'),
                        'dt'=> Request::get('dt'),
                      ];

?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Leave Card List</h1>
  </section>

  <section class="content">
    

    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.leave_card.index') }}">


    {{-- Advance Filters --}}
    {!! __html::filter_open() !!}

      <div class="col-md-12 no-padding">

        {!! 
          __form::select_dynamic_for_filter('3', 'emp', 'Employee', old('emp'), $global_employees_all, 'employee_no', 'fullname', 'submit_lc_filter', 'select2', 'style="width:100%;"') 
        !!}

        {!!
          __form::select_static_for_filter('3', 'doc_t', ' Doc Type', old('doc_t'), __static::document_types_leave_card(), 'submit_lc_filter', '', '') 
        !!}

        {!!
          __form::select_static_for_filter('3', 'leave_t', ' Leave Type', old('leave_t'), __static::leave_types(), 'submit_lc_filter', '', '') 
        !!}

      </div>


      <div class="col-md-12 no-padding">
        
        <h5>Date Filter : </h5>

        {!! __form::datepicker('3', 'df',  'From', old('df'), '', '') !!}

        {!! __form::datepicker('3', 'dt',  'To', old('dt'), '', '') !!}

        <button type="submit" class="btn btn-primary" style="margin:25px;">Filter Date <i class="fa fa-fw fa-arrow-circle-right"></i></button>

      </div>
        
    {!! __html::filter_close('submit_lc_filter') !!}



    <div class="box" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.leave_card.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('employee.fullname', 'Employee')</th>
            <th>@sortablelink('doc_type', 'Doc Type')</th>
            <th>@sortablelink('leave_type', 'Leave Type')</th>
            <th>Date</th>
            <th>@sortablelink('credits', 'Credits')</th>
            <th style="width: 150px">Action</th>
          </tr>
          @foreach($leave_cards as $data) 
            <tr {!! __html::table_highlighter( $data->slug, $table_sessions) !!}>
              <td id="mid-vert">{!! empty($data->employee) ? '' : $data->employee->fullname !!}</td>
              <td id="mid-vert">{{ $data->doc_type }}</td>
              <td id="mid-vert">{{ $data->doc_type == 'LEAVE' ? $data->leave_type : 'N/A' }}</td>
              <td id="mid-vert">
                @if($data->doc_type == 'LEAVE')
                  {{ __dataType::date_parse($data->date_from, 'M d, Y') .' - '. __dataType::date_parse($data->date_to, 'M d, Y') }}
                @else
                  {{ __dataType::date_parse($data->date, 'M d, Y') }}
                @endif
              </td>
              <td id="mid-vert">
                {!! 
                  $data->doc_type == 'OT' ? '<span class="text-success">'. $data->credits .'</span>' : '<span class="text-danger">'. $data->credits .'</span>'; 
                !!}
              </td>
              <td id="mid-vert"> 
                <select id="action" class="form-control input-md">
                  <option value="">Select</option>
                  <option data-type="1" data-url="{{ route('dashboard.leave_card.show', $data->slug) }}">Details</option>
                  <option data-type="1" data-url="{{ route('dashboard.leave_card.edit', $data->slug) }}">Edit</option>
                  <option data-type="0" data-action="delete" data-url="{{ route('dashboard.leave_card.destroy', $data->slug) }}">Delete</option>
                </select>
              </td>
            </tr>
            @endforeach
        </table>
      </div>

      @if($leave_cards->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($leave_cards) !!}
        {!! $leave_cards->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
      </div>

    </div>

  </section>

@endsection





@section('modals')

  {!! __html::modal_delete('lc_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::modal_confirm_delete_caller('lc_delete') !!}

    {{-- LC UPDATE TOAST --}}
    @if(Session::has('LC_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('LC_UPDATE_SUCCESS')) !!}
    @endif

    {{-- LC DELETE TOAST --}}
    @if(Session::has('LC_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('LC_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection