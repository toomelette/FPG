@extends('layouts.admin-master')

@section('content')

  <section class="content-header">
    <h1>Applicant Reports</h1>
  </section>

  <section class="content">

    <div class="box">

    <div class="box-header with-border">
      <h3 class="box-title">Report</h3>
      <div class="pull-right">
        <code>Fields with asterisks(*) are required</code>
      </div>
    </div>

    <form id="report_generate_form">

      <div class="box-body">

        <div class="col-md-3">
          <div class="well well-sm">
            Select:
            <form id="report_generate_form">
              <div class="row">
                {!! __form::select_static(
                '12', 'layout', 'Layout:*', 'all',
                [
                'List All' => 'all',
                'List by Course' => 'by_course',
                'List by Position Applied'=> 'by_position_applied',
                'List by Item No.' => 'by_item_no',
                ], '', '', '',''
              ) !!}
              </div>
              Filters:

              <div class="row">
                @php
                  $db_courses = \App\Models\Applicant::select('course')->where('course','!=',null)->groupBy('course')->orderBy('course','asc')->pluck('course')->toArray();
                  $courses = ['All' => ''];
                  if(count($db_courses) > 0){
                    foreach($db_courses as $db_course){
                      $courses[$db_course] = $db_course;
                    }
                  }
                @endphp

                {!! __form::select_static(
                    '12', 'course', 'Select Course: *', old('lt'), $courses, '', '', 'select2', ''
                  ) !!}

{{--                {!! __form::select_dynamic(--}}
{{--                  '12', 'unit_applied', 'Unit Applied', old('du'), $global_department_units_all, 'department_unit_id', 'description', $errors->has('du'), $errors->first('du'), 'select2', ''--}}
{{--                ) !!}--}}

                @php
                  $db_positions = \App\Models\ApplicantPositionApplied::select('position_applied')->groupBy('position_applied')->orderBy('position_applied','asc')->pluck('position_applied')->toArray();
                  $positions = ['All' => ''];
                  if(count($db_positions) > 0){
                    foreach($db_positions as $db_position){
                      $positions[$db_position] = $db_position;
                    }
                  }
                @endphp

                {!! __form::select_static(
                    '12', 'position_applied', 'Select Position *', old('lt'), $positions, '', '', 'select2', ''
                  ) !!}


                @php
                  $db_items = \App\Models\HRPayPlanitilla::select('item_no','position')->orderBy('item_no','asc')->get();
                  $items = ['All' => ''];
                  if(!empty($db_items)){
                    foreach($db_items as $db_item){
                      $items[$db_item->item_no.' - '.$db_item->position] = $db_item->item_no ;
                    }
                  }
                @endphp

                {!! __form::select_static(
                    '12', 'item_no', 'Select Item No. *', old('lt'), $items, '', '', 'select2', ''
                  ) !!}
              </div>
              <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="filter_date_checkbox"> Filter Date
                        </label>
                      </div>
                      <label>Select date range:</label>
                      <div class="input-group">

                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input name="date_range" type="text" class="form-control pull-right filters" id="date_range" autocomplete="off" disabled>

                      </div>
                    </div>
                  </div>
                <div class="col-md-12">
                  <label>Options:</label>
                  <div class="row">
                    <div class="col-md-5">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" checked name="page_break"> Add page break
                        </label>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" checked name="headers_per_page"> Add headers per page break
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="col-md-12">
                    <br>
                    Select columns to show: <span class="text-info text-strong pull-right">(Drag to reorder)</span>
                    <ol class="for_sort sortable todo-list">
                      @foreach($columns as $key=>$column)
                        <li>
                          <div class="checkbox" style="margin: 0">
                            <label>
                              <input checked="" type="checkbox" name="columns[]" value="{{$key}}"> {{$column}}
                            </label>
                          </div>
                        </li>
                      @endforeach
                    </ol>
                  </div>

                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="pull-right">
                      <button class="btn btn-success">
                        Generate
                      </button>
                    </div>
                  </div>
                </div>
            </form>
          </div>
        </div>

        <div class="col-md-9">
          <div class="panel panel-default">
            <div class="panel-heading clearfix">
                        <span style="font-weight: bold; font-size: 16px">
                          Print Preview
                        </span>
              <button type="button" id="print_btn" class="btn btn-success btn-sm pull-right"><i class="fa fa-print"></i> Print</button>
            </div>

            <div id="spinner_container" style="display: none">
              <div style="text-align:center; margin-top: 150px">
                <i class="fa fa-spin fa-spinner" style="font-size:150px;color:#00A65A"></i>

                <p style="margin-top: 50px">Generating report...</p>
              </div>
            </div>


            <div class="panel-body" style="height: 700px">
              <div id="print_container" style="text-align: center; margin-top: 100px">
                <i class="fa fa-print" style="font-size: 300px; color: grey; "></i>
                <br>
                <span class="text-info">Click <b>"Generate"</b> button to see print preview here</span>
              </div>


              <div id="report_container" style="display: none">
                <iframe id="report_frame" style="width: 100%; height: 650px; border: none" class="embed-responsive" src="">

                </iframe>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>

    </div>







  </section>

@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $('#date_range').daterangepicker();
    $('#date_range').attr('disabled','disabled');

    $("#filter_date_checkbox").change(function () {
      if($(this).prop('checked') == true){
        $('#date_range').removeAttr('disabled');s
      }else{
        $('#date_range').attr('disabled','disabled');
      }
    });

    $(".for_sort").sortable();

    $("#report_generate_form").submit(function(e){
      $("#report_container").hide();
      $("#print_container").slideUp();
      $("#spinner_container").fadeIn();
      e.preventDefault();
      data = $(this).serialize();

      url  = "{{route('dashboard.applicant.report_generate')}}";
      $("#report_frame").attr('src', url+"?"+data );
    })

    $("#report_frame").on("load",function(){
      $("#spinner_container").slideUp(function(){
        $("#report_container").fadeIn();
      })

    })
    $("#print_btn").click(function(){
      $("#report_frame").get(0).contentWindow.print();
    })

  })

</script>
@endsection