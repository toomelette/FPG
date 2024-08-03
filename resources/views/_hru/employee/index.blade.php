@extends('adminkit.master')

@section('content2')


    @if(Route::currentRouteName() == 'dashboard.employee.index')
        <x-adminkit.html.page-title>
            <x-slot:title>Manage Permanent Employees</x-slot:title>
        </x-adminkit.html.page-title>
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
            <x-adminkit.html.alert type="warning" dismissible="0">
                <strong>Warning! Please assign Plantilla Item No. on the following ACTIVE {{str_plural('employee',$noItems)}} (or mark them as inactive): {{$noItems->count()}}</strong>
                <div class="row">
                    @forelse($noItems as $noItem)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            • <a href="{{route('dashboard.employee.edit',$noItem->slug)}}">{{$noItem->full['FMiLE']}}</a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </x-adminkit.html.alert>

            @php
                $errs++;
            @endphp
        @endif

        @if(!empty($appointmentStatuss) && $appointmentStatuss->count() > 0)
            <x-adminkit.html.alert type="warning" dismissible="0">
                <strong>Warning! Please indicate appointment status on the following active {{str_plural('employee',$appointmentStatuss)}}: {{$appointmentStatuss->count()}}</strong>
                <div class="row">
                    @forelse($appointmentStatuss as $appointmentStatus)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            • <a href="{{route('dashboard.employee.edit',$appointmentStatus->slug)}}">{{$appointmentStatus->full['FMiLE']}}}}</a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </x-adminkit.html.alert>
            @php
                $errs++;
            @endphp
        @endif

        @if(!empty($noRcs) && $noRcs->count() > 0)
            <x-adminkit.html.alert type="warning" dismissible="0">
                <strong>Warning! Please assign Responsibility Center on the following active {{str_plural('employee',$noRcs)}}: {{$noRcs->count()}}</strong>
                <div class="row">
                    @forelse($noRcs as $noRc)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                            • <a href="{{route('dashboard.employee.edit',$noRc->slug)}}">{{$noRc->full['FMiLE']}}}}</a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </x-adminkit.html.alert>
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
                <x-adminkit.html.alert type="warning" dismissible="0">
                    <strong>Warning! Please indicate the full MIDDLE NAME of the following {{str_plural('employee',$middles)}}: {{$middles->count()}}</strong>
                    <div class="row">
                        @forelse($middles as $middle)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                                • <a href="{{route('dashboard.employee.edit',$middle->slug)}}">{{$middle->full['FMiLE']}}}}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </x-adminkit.html.alert>
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
                <x-adminkit.html.alert type="warning" dismissible="0">
                    <strong>Warning! Please indicate the JOB GRADE and/or STEP INC of the following {{str_plural('employee',$noSgSi)}}: {{$noSgSi->count()}}</strong>
                    <div class="row">
                        @forelse($noSgSi as $e)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                                • <a href="{{route('dashboard.employee.edit',$e->slug)}}">{{$e->full['FMiLE']}}}}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </x-adminkit.html.alert>
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
                <x-adminkit.html.alert type="warning" dismissible="0">
                    <strong>Please update the last names and first names of the following  {{$exts->count()}} {{str_plural('employee',$exts)}} by removing any name extensions and indicating them to a dedicated field labeled "Name Ext." </strong>
                    <div class="row">
                        @forelse($exts as $e)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
                                • <a href="{{route('dashboard.employee.edit',$e->slug)}}">{{$e->full['FMiLE']}}</a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </x-adminkit.html.alert>
            @endif
            @php
                $errs++;
            @endphp
        @endif


    @else
        <x-adminkit.html.page-title>
            <x-slot:title>Manage COS Employees</x-slot:title>
        </x-adminkit.html.page-title>
    @endif


    <div class="card">
        <div class="card-body">
            <x-adminkit.html.accordion id="filter-accordion" class="accordion-sm mb-3" state="0">
                <x-slot:title>
                    <i class="fas fa fa-filter"></i> Advanced Filters
                </x-slot:title>
                <form id="filter_form">
                    <div class="row">
                        <x-forms.select label="Status" cols="2" container-class="dt_filter-parent-div" name="is_active" class="dt_filter filters" :options="\App\Models\SuOptions::employeeStatus()->mapWithKeys(function ($data){return [$data->option => $data->value];})"/>
                        <x-forms.select label="Sex" cols="2" container-class="dt_filter-parent-div" name="sex" class="dt_filter filter_sex" :options="['MALE' => 'MALE','FEMALE' => 'FEMALE']"/>

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
                        <x-forms.select label="Assignment" cols="2" container-class="dt_filter-parent-div" name="assignment" class="dt_filter filter_sex filters" :options="\App\Swep\Helpers\Arrays::employeeAssignments()"/>
                        <x-forms.select label="Resp. Center" cols="3" container-class="dt_filter-parent-div" name="resp_center" class="dt_filter filter_sex filters select2-parent-card" :options="\App\Swep\Helpers\Arrays::groupedRespCodes(true)"/>
                    </div>
                </form>
            </x-adminkit.html.accordion>

            <div id="employees_table_container">
                <table class="table table-bordered table-striped table-hover table-sm" id="employees_table" style="width: 100%">
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
        </div>
    </div>


@endsection


@section('modals')
    <x-adminkit.html.modal id="show_employee_modal" size="90"/>



{!! \App\Swep\ViewHelpers\__html::blank_modal('trainings_modal','80') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('matrix_modal','lg') !!}



{!! \App\Swep\ViewHelpers\__html::blank_modal('add_training_modal','') !!}



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
      "ajax" : '{{\Illuminate\Support\Facades\Request::getUri()}}',
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
              "targets" : '_all',
              "class" : 'align-top'
          },
        {
          "targets" : 5,
          "orderable" : false,
          "searchable": false,
          "class" : 'action4ff'
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
          },
          {
              "targets" : 2,
              "class" : 'v-top'
          }

      ],
      "responsive": true,
      "initComplete": function( settings, json ) {
            // console.log(settings);
          setTimeout(function () {
              $("#filter_form select[name='is_active']").val('ACTIVE');
              // $("#filter_form select[name='is_active']").trigger('change');
              let data = $("#filter_form").serialize();
              employees_tbl.ajax.url("{{\Illuminate\Support\Facades\URL::current()}}"+"?is_active="+$("#filter_form select[name='is_active']").val());
          },100);

          setTimeout(function () {
              // $('a[href="#advanced_filters"]').trigger('click');
              $('.advanced_filters_toggler').trigger('click');
          },1000);

          if(find != ''){
              employees_tbl.search(find).draw();
              setTimeout(function(){
                  active = '';
              },3000);
              window.history.pushState({}, document.title, "/dashboard/employee");
          }

          @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
          setTimeout(function () {
              employees_tbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
              active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
              toast('info','Employee successfully updated.','Updated!');
              window.history.pushState({}, document.title, "/dashboard/employee");
          },700);
          @endif
      },
        "drawCallback": function(settings){
            // console.log(employees_tbl.page.info().page);
            $("#employees_table a[for='linkToEdit']").each(function () {
                let orig_uri = $(this).attr('href');
                $(this).attr('href',orig_uri+'?page='+employees_tbl.page.info().page);
            });

            if(active != ''){
                $("#employees_table #"+active).addClass('table-success');
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