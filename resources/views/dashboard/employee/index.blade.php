@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    @if(Route::currentRouteName() == 'dashboard.employee.index')
        <h1>Manage Permanent Employees</h1>
        @php
            $noItems = \App\Models\Employee::query()
                    ->where(function ($q){
                        $q->where('item_no','=',null)
                        ->orWhere('item_no','=','');
                    })
                    ->where('appointment_status','!=','Coterminous')
                    ->applyProjectId()
                    ->permanent()
                    ->active()
                    ->get();

            $appointmentStatuss = \App\Models\Employee::query()
                    ->where(function ($q){
                        $q->where('appointment_status','=',null)
                        ->orWhere('appointment_status','=','');
                    })
                    ->applyProjectId()
                    ->permanent()
                    ->active()
                    ->get();

            $noRcs = \App\Models\Employee::query()
                    ->where(function ($q){
                        $q->where('resp_center','=',null)
                        ->orWhere('resp_center','=','');
                    })
                    ->removeBoardMember()
                    ->applyProjectId()
                    ->permanent()
                    ->active()
                    ->get();

            $errs = 0;
        @endphp
        @if(!empty($noItems) && $noItems->count() > 0)
            <div class="callout callout-danger" style="margin-top: 10px">
                <h4>Warning! Please assign Plantilla Item No. on the following active {{str_plural('employee',$noItems)}}: {{$noItems->count()}}</h4>
                <div class="row">
                    @forelse($noItems as $noItem)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            • <a href="{{route('dashboard.employee.edit',$noItem->slug)}}">{{$noItem->full_name}}</a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            @php
            $errs++;
            @endphp
        @endif

        @if(!empty($appointmentStatuss) && $appointmentStatuss->count() > 0)
            <div class="callout callout-danger" style="margin-top: 10px">
                <h4>Warning! Please indicate appointment status on the following active {{str_plural('employee',$appointmentStatuss)}}: {{$appointmentStatuss->count()}}</h4>
                <div class="row">
                    @forelse($appointmentStatuss as $appointmentStatus)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            • <a href="{{route('dashboard.employee.edit',$appointmentStatus->slug)}}">{{$appointmentStatus->full_name}}</a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            @php
                $errs++;
            @endphp
        @endif

        @if(!empty($noRcs) && $noRcs->count() > 0)
            <div class="callout callout-danger" style="margin-top: 10px">
                <h4>Warning! Please assign Responsibility Center on the following active {{str_plural('employee',$noRcs)}}: {{$noRcs->count()}}</h4>
                <div class="row">
                    @forelse($noRcs as $noRc)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            • <a href="{{route('dashboard.employee.edit',$noRc->slug)}}">{{$noRc->full_name}}</a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            @php
                $errs++;
            @endphp
        @endif

        @if($errs < 3)
            @php
                $middles = \App\Models\Employee::query()
                        ->whereRaw('LENGTH(middlename) = 1')
                        ->applyProjectId()
                        ->permanent()
                        ->active()
                        ->get();
            @endphp
            @if(!empty($middles) && $middles->count() > 0)
                <div class="callout callout-danger" style="margin-top: 10px">
                    <h4>Warning! Please indicate the full MIDDLE NAME of the following {{str_plural('employee',$middles)}}: {{$middles->count()}}</h4>
                    <div class="row">
                        @forelse($middles as $middle)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                                • <a href="{{route('dashboard.employee.edit',$middle->slug)}}">{{$middle->full_name}}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
            @php
                $errs++;
            @endphp
        @endif
        @if($errs < 3)
            @php
                $noSgSi = \App\Models\Employee::query()
                    ->where(function ($q){
                        $q->orWhere('salary_grade','=',null)
                        ->orWhere('salary_grade','=','')
                        ->orWhere('step_inc','=',null)
                        ->orWhere('step_inc','=','');
                    })
                    ->applyProjectId()
                    ->permanent()
                    ->active()
                    ->removeBoardMember()
                    ->get();
            @endphp
            @if(!empty($noSgSi) && $noSgSi->count() > 0)
                <div class="callout callout-danger" style="margin-top: 10px">
                    <h4>Warning! Please indicate the JOB GRADE and/or STEP INC of the following {{str_plural('employee',$noSgSi)}}: {{$noSgSi->count()}}</h4>
                    <div class="row">
                        @forelse($noSgSi as $e)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                                • <a href="{{route('dashboard.employee.edit',$e->slug)}}">{{$e->full_name}}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
            @php
                $errs++;
            @endphp
        @endif

        {{-- check for juniors --}}
        @if($errs < 3)
            @php
                $exts = \App\Models\Employee::query()
                    ->where(function ($q){
                        $q->orWhere('firstname','like','% JR%')
                        ->orWhere('lastname','like','% JR%')
                        ->orWhere('firstname','like','% SR%')
                        ->orWhere('lastname','like','% SR%')
                        ->orWhere('firstname','like','% III%')
                        ->orWhere('lastname','like','% III%')
                        ->orWhere('firstname','like','% IV%')
                        ->orWhere('lastname','like','% IV%');
                    })
                    ->applyProjectId()
                    ->permanent()
                    ->active()
                    ->removeBoardMember()
                    ->get();

            @endphp
            @if(!empty($exts) && $exts->count() > 0)
                <div class="callout callout-danger" style="margin-top: 10px">
                    <h4>
                        Please update the last names and first names of the following  {{$exts->count()}} {{str_plural('employee',$exts)}} by removing any name extensions and indicating them to a dedicated field labeled "Name Ext." </h4>
                    <div class="row">
                        @forelse($exts as $e)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                                • <a href="{{route('dashboard.employee.edit',$e->slug)}}">{{$e->full_name}}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
            @php
                $errs++;
            @endphp
        @endif


    @else
        <h1>Manage COS Employees</h1>
    @endif

</section>

<section class="content">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">List of Employees</h3>
        </div>
        <div class="box-body">
            <div class="panel">
                <div class="box box-sm box-default box-solid collapsed-box">
                    <div class="box-header with-border">
                        <p class="no-margin"><i class="fa fa-filter"></i> Advanced Filters <small id="filter-notifier" class="label bg-blue blink"></small></p>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool advanced_filters_toggler" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="box-body" style="display: none">
                        <form id="filter_form">
                            <div class="row">
                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Status:</label>
                                    <select name="is_active"  class="form-control dt_filter filters">
                                        <option value="">Don't filter</option>
                                        {!! \App\Swep\Helpers\Helper::populateOptionsFromObject(\App\Models\SuOptions::employeeStatus(),'option','value') !!}
                                    </select>
                                </div>
                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Sex:</label>
                                    <select name="sex"  class="form-control dt_filter filter_sex filters select22">
                                        <option value="">Don't filter</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                </div>

                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Location:</label>
                                    <select name="locations"  class="form-control dt_filter filter_locations filters select22">
                                        <option value="">Don't filter</option>
                                        @if(Route::currentRouteName() == 'dashboard.employee.index')
                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromObject(\App\Models\SuOptions::employeeGroupingsPermanent(),'option','value') !!}
                                        @else
                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromObject(\App\Models\SuOptions::employeeGroupingsCos(),'option','value') !!}
                                        @endif
                                    </select>
                                </div>
                                {!! \App\Swep\ViewHelpers\__form2::select('assignment',[
                                    'class' => 'dt_filter filter_sex filters select22',
                                    'cols' => '2 dt_filter-parent-div',
                                    'label' => 'Assignment:',
                                    'options' => \App\Swep\Helpers\Arrays::employeeAssignments(),
                                ]) !!}

                                {!! \App\Swep\ViewHelpers\__form2::select('resp_center',[
                                    'class' => 'dt_filter filter_sex filters select2',
                                    'cols' => '3 dt_filter-parent-div',
                                    'label' => 'Resp. Center:',
                                    'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(true),
                                ]) !!}
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <br>
            <div id="employees_table_container" style="display: none">
                <table class="table table-bordered table-striped table-hover" id="employees_table" style="width: 100%">
                    <thead>
                    <tr class="">
                        <th >Full Name</th>
                        <th class="th-20">Employment Details</th>
                        <th >Position</th>
                        <th >Photo</th>
                        <th >BM id</th>
                        <th class="action">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div id="tbl_loader">
                <center>
                    <img style="width: 100px" src="{{asset('images/loader.gif')}}">
                </center>
            </div>
        </div>
    </div>
</section>


@endsection


@section('modals')
{!! \App\Swep\ViewHelpers\__html::blank_modal('show_employee_modal','75') !!}

{!! \App\Swep\ViewHelpers\__html::blank_modal('service_records_modal','lg') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('trainings_modal','80') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('matrix_modal','lg') !!}


{!! \App\Swep\ViewHelpers\__html::blank_modal('add_sr_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('add_training_modal','') !!}


{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_sr_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_training_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_matrix_modal','40') !!}

{!! \App\Swep\ViewHelpers\__html::blank_modal('file201_modal','lg') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('add_file201_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_file201_modal','') !!}



{!! \App\Swep\ViewHelpers\__html::blank_modal('credentials_modal','80') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('add_educ_bg_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_educ_bg_modal','') !!}

{!! \App\Swep\ViewHelpers\__html::blank_modal('add_elig_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_elig_modal','') !!}

{!! \App\Swep\ViewHelpers\__html::blank_modal('add_work_modal','') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_work_modal','') !!}

{!! \App\Swep\ViewHelpers\__html::blank_modal('other_hr_actions_modal','80') !!}

{{-- Print Modal --}}
<div class="modal fade" id="print_sr_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Please set signatories</h4>
            </div>
            <form id="print_sr_form" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="row">
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

                        {!! __form::textbox(
                           '6', 'an', 'text', 'Approved By:', 'Approved By', old('cn'), $errors->has('cn'), $errors->first('cn'), 'data-transform="uppercase"'
                        ) !!}

                        {!! __form::textbox(
                           '6', 'ap', 'text', 'Approved Position:', 'Approved Position', old('cp'), $errors->has('cp'), $errors->first('cp'), 'data-transform="uppercase"'
                        ) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('no_of_items',[
                            'cols' => 6,
                            'label' => 'No. of items per page:',
                            'type' => 'number',
                        ],35) !!}
                    </div>

                </div>
                <div class="modal-footer" style="overflow: hidden;">
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Print</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="print_training_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="print_training_form" target="_blank" action="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Filter</h4>
                </div>
                <div class="modal-body">
                    <p class="text-info"><i class="fa fa-info-circle"></i> Leaving these fields blank will not filter trainings by date.</p>
                    <div class="row">

                        {!! __form::textbox(
                            '6 df', 'df', 'date', 'Date From', 'Date From','', '', '', ''
                         ) !!}

                        {!! __form::textbox(
                          '6 dt', 'dt', 'date', 'Date To', 'Date To', '', '', '', ''
                        ) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('items_per_sheet',[
                            'cols' => 3,
                            'label' => 'Items per sheet',
                            'type' => 'number',
                        ],20) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <iframe id="training_frame" src="" style="width: 1px;height: 1px; float: left"></iframe>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('scripts')
<script type="text/javascript">
    function dt_draw() {
        users_table.draw(false);
    }

    function filter_dt() {
        is_online = $(".filter_status").val();
        is_active = $(".filter_account").val();
        users_table.ajax.url("{{ route('dashboard.user.index') }}" + "?is_online=" + is_online + "&is_active=" + is_active).load();

        $(".filters").each(function (index, el) {
            if ($(this).val() != '') {
                $(this).parent("div").addClass('has-success');
                $(this).siblings('label').addClass('text-green');
            } else {
                $(this).parent("div").removeClass('has-success');
                $(this).siblings('label').removeClass('text-green');
            }
        });
    }
</script>
<script type="text/javascript">

    //-----DATATABLES-----//
    modal_loader = $("#modal_loader").parent('div').html();
    //Initialize DataTable
    active = '';
    employees_tbl = $("#employees_table").DataTable({
      'dom' : 'lBfrtip',
      "processing": true,
      "serverSide": true,
      "ajax" : '{{route('dashboard.employee.index')}}',
      "columns": [
        { "data": "fullname" },
        { "data": "employee_no" },
        { "data": "position" },
        { "data": "photo" },
        { "data": "biometric_user_id" },
        { "data": "action"}
      ],
      "buttons": [
        {!! __js::dt_buttons() !!}
      ],
      "columnDefs":[
        {
          "targets" : 5,
          "orderable" : false,
          "searchable": false,
          "class" : 'action4'
        },
          {
              "targets" : 4,
              "visible" : false,
          },
        {
          "targets" : 0,
          "class" : 'w-30p'
        },
          {
              "targets" : 3,
              "class" : 'w-10p'
          }

      ],
      "responsive": true,
      "initComplete": function( settings, json ) {
            // console.log(settings);
          setTimeout(function () {
              $("#filter_form select[name='is_active']").val('ACTIVE');
              $("#filter_form select[name='is_active']").trigger('change');
          },100);

          setTimeout(function () {
              // $('a[href="#advanced_filters"]').trigger('click');
              $('.advanced_filters_toggler').trigger('click');
          },1000);

            $('#tbl_loader').fadeOut(function(){
              $("#employees_table_container").fadeIn();
                if(find != ''){
                    employees_tbl.search(find).draw();
                    setTimeout(function(){
                        active = '';
                    },3000);
                    window.history.pushState({}, document.title, "/dashboard/employee");
                }
            });
          @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
          setTimeout(function () {
              employees_tbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
              active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
              notify('Employee successfully updated.');
              window.history.pushState({}, document.title, "/dashboard/employee");
          },700);
          @endif
      },
      "language":
              {
                "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
              },
        "drawCallback": function(settings){
            // console.log(employees_tbl.page.info().page);
            $("#employees_table a[for='linkToEdit']").each(function () {
                let orig_uri = $(this).attr('href');
                $(this).attr('href',orig_uri+'?page='+employees_tbl.page.info().page);
            });

            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(active != ''){
                $("#employees_table #"+active).addClass('success');
            }
        }
    })

    style_datatable("#employees_table");

    //Need to press enter to search
    $('#employees_table_filter input').unbind();
    $('#employees_table_filter input').bind('keyup', function (e) {
      if (e.keyCode == 13) {
          employees_tbl.search(this.value).draw();
      }
    });
    
    $("body").on('click','.view_employee_btn', function () {
        btn = $(this);
        load_modal2(btn);
        uri = '{{route("dashboard.employee.show","slug")}}';
        uri = uri.replace("slug",btn.attr('data'));
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
               populate_modal2(btn,res);
            },
            error: function (res) {
                notify('Error','danger');
                console.log(res);
            }
        })
    })

    $("body").on("click",'.service_records_btn',function () {
        btn = $(this);
        uri = '{{route("dashboard.employee.service_record","slug")}}';
        uri = uri.replace('slug',btn.attr('data'));
        load_modal2(btn);
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                notify('Ajax error','danger');
                console.log(res);
            }
        })
    })

    $("body").on("click",".trainings_btn",function (e) {
        btn = $(this);
        uri = '{{route("dashboard.employee.training","slug")}}';
        uri = uri.replace('slug',btn.attr('data'));
        load_modal2(btn);
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                notify('Ajax error','danger');
                console.log(res);
            }
        })
    })

    $("body").on("click",".matrix_btn",function (e) {
        btn = $(this);
        uri = '{{route("dashboard.employee.matrix_show","slug")}}';
        uri = uri.replace('slug',btn.attr('data'));
        load_modal2(btn);
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                notify('Ajax error','danger');
                console.log(res);
            }
        })
    })

    $("body").on("click",".bm_uid_btn",function () {
        let bm_uid = $(this).attr('bm_uid');
        let employee = $(this).attr('data');
        Swal.fire({
            title: 'Enter Biometric User ID:',
            html: 'Employee: <b>'+$(this).attr('employee')+'</b>',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
            },
            inputValue: bm_uid,
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            preConfirm: (text) => {
                return $.ajax({
                        url : "{{route('dashboard.employee.update_bm_uid')}}",
                        data : {'biometric_user_id':text , 'employee' : employee},
                        type: 'POST',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                           active = res.slug;
                           employees_tbl.draw(false);
                            notify('Biometric User ID was successfully changed','success');
                        },
                        error: function (res) {
                            if(res.status == 422){
                                var message = res.responseJSON.errors.biometric_user_id;
                            }else{
                                var message = res.responseJSON.message;
                            }
                            Swal.showValidationMessage(
                                'Request failed: ' + message
                            );
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {

                    })

            },
            allowOutsideClick: () => !Swal.isLoading()
        })
    })

    $(".dt_filter").change(function () {
        filterDT(employees_tbl);
    })

    $("body").on("click",".file201_btn",function () {
        let btn = $(this);
        load_modal2(btn);
        $.ajax({
            url : btn.attr('uri'),
            data : {employee : btn.attr('data')},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
               populate_modal2(btn,res);
            },
            error: function (res) {
                populate_modal2_error(res);
            }
        })
    })

    $("body").on("click",".other_actions_btn",function () {
        btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.employee.other_hr_actions","slug")}}';
        uri = uri.replace('slug',btn.attr('data'));
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                populate_modal2_error(res);
            }
        })
    })

    $("body").on("click",".credentials_btn",function () {
        let btn = $(this);
        let uri = '{{route("dashboard.employee.credentials","slug")}}';
        uri = uri.replace('slug',btn.attr('data') );
        load_modal2(btn);
        $.ajax({
            url : uri,
            data : '',
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                populate_modal2_error(res);
            }
        })
    })
    // window.history.pushState({}, document.title, "/dashboard/employee");
    $("#print_training_form").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        $("#training_frame").attr('src',form.attr('action')+'?'+form.serialize());
    })



</script>
@endsection