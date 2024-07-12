@extends('layouts.modal-content')
@php
  $rand = Str::random();
@endphp
@section('modal-header')
{{(!empty($user->employee) ? $user->employee->lastname : $user->lastname)}}, {{(!empty($user->employee) ? $user->employee->firstname : $user->firstname)}}
@endsection

@section('modal-body')
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">User Information</a></li>
      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">User Access</a></li>
      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Activity Logs</a></li>

    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
        <div class="row">
          <div class="col-md-3">
            <b>First Name:</b>
            <p>{{$user->firstname}}</p>
          </div>
          <div class="col-md-3">
            <b>Middle Name:</b>
            <p>{{$user->middlename}}</p>
          </div>
          <div class="col-md-3">
            <b>Last Name:</b>
            <p>{{$user->lastname}}</p>
          </div>
          <div class="col-md-3">
            <b>Email Address:</b>
            <p>{{$user->email}}</p>
          </div>

          <div class="col-md-3">
            <b>Position:</b>
            <p>{{$user->position}}</p>
          </div>


          <div class="col-md-3">
            <b>Account:</b>
            <p>

              @if($user->is_activated == false)
                <span class="label bg-red">DEACTIVATED</span>
              @else
                <span class="label bg-green">ACTIVE</span>
              @endif
            </p>
          </div>

        </div>

      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        @if(count($tree) > 0)
          @foreach($tree as $key=>$menu)
            <div>
              <div class="row">
                <div class="col-md-8">
                  <i class="fa {{$menu['menu_obj']->icon ?? ''}}"></i>
                  <label>{{$menu['menu_obj']->name ?? ''}}</label>
                </div>
                <div class="col-md-4">
                  <div class="progress xs">
                    @if($menus_with_count_submenus[$key] != 0)
                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:{{count($menu['submenus'])/$menus_with_count_submenus[$key]*100}}%">
                    </div>
                    @endif
                  </div>
                </div>

              </div>
              <div class="row">
                @if(count($menu['submenus']) > 0)
                  @foreach($menu['submenus'] as $submenu)
                    <div class="col-md-4">
                      <li>{{$submenu->name ?? ''}}</li>
                    </div>
                  @endforeach
                @endif
              </div>
              <hr>
            </div>
          @endforeach
        @endif
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_3">
        <table class="table table-condensed" id="table_logs_{{$rand}}" style="width: 100%;">
          <thead>
            <tr>
              <th>Timestamp</th>
              <th>Event</th>
              <th>Module</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
@endsection

@section('modal-footer')

@endsection

@section('scripts')
  <script>
    var logsTbl_{{$rand}} = $("#table_logs_{{$rand}}").DataTable({
      'dom' : 'lBfrtip',
      "processing": true,
      "serverSide": true,
      "ajax" : '{{route('dashboard.user.show',$user->user_id)}}',
      "columns": [
        { "data": "created_at" },
        { "data": "event" },
        { "data": "log_name" },
        { "data": "details" },
      ],
      "buttons": [
        {!! __js::dt_buttons() !!}
      ],
      "columnDefs":[
        {
          targets: 0,
          class: 'w-30p'
        },

      ],
      "responsive": true,
      "initComplete": function( settings, json ) {

      },
      order:[[0,'desc']],
      "language":
              {
                "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
              },
      "drawCallback": function(settings){

      }
    })

    style_datatable("#table_logs_{{$rand}}");

    //Need to press enter to search
    $('#table_logs_{{$rand}}_filter input').unbind();
    $('#table_logs_{{$rand}}_filter input').bind('keyup', function (e) {
      if (e.keyCode == 13) {
        employees_tbl.search(this.value).draw();
      }
    });


  </script>
@endsection

