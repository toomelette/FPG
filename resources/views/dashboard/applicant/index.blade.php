@extends('layouts.admin-master')

@section('content')
    <style>
        .select2-container{
            width: 100% !important;
        }
    </style>
    <section class="content-header">
        <h1>Applicants</h1>

        <button hidden id='temp_btn' type="button" class="edit_applicant_btn" data-target="#edit_applicant_modal" data-toggle="modal"></button>
    </section>

    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">List of Applicants</h3>
                <button data-step="1" data-intro="Add applicant by using this button." class="btn btn-primary pull-right btn-sm" data-toggle="modal" data-target="#add_applicant_modal"><i class="fa fa-plus"></i> Create</button>
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
                                    <x-forms.select label="Course" cols="2" container-class="dt_filter-parent-div" name="course" class="dt_filter filters select2_course_filter" :options="[]"/>
                                    <x-forms.select label="Sex" cols="2" container-class="dt_filter-parent-div" name="sex" class="dt_filter filter_sex" :options="['MALE' => 'MALE','FEMALE' => 'FEMALE']"/>




                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>Civil Status:</label>
                                        <select name="civil_status"  class="form-control dt_filter filter_locations filters select22">
                                            <option value="">Don't filter</option>
                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromArray(\App\Swep\Helpers\Arrays::civil_status()) !!}
                                        </select>
                                    </div>

                                    <div class="col-md-4 dt_filter-parent-div">
                                        <label>Position applied for:</label>
                                        <select name="position_applied"  class="form-control dt_filter filters select2_position_applied_filter">
                                            <option value="">Don't filter</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 10px">
                                    <div class="col-md-4 dt_filter-parent-div">
                                        <label>Item No:</label>
                                        <select name="item_no"  class="form-control dt_filter filters select2_item_no_filter">
                                            <option value="">Don't filter</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <br>
                <div id="applicants_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="applicants_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Name</th>
                            <th>Position(s) Applied</th>
                            <th >Course</th>
                            <th >Age</th>
                            <th ><small>Appln. Date</small></th>
                            <th >SL</th>
                            <th class="action">Action</th>
                            <th>Updated at</th>
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
            <!-- /.box-body -->
        </div>
    </section>

@endsection


@section('modals')
    {!! \App\Swep\ViewHelpers\__html::blank_modal('edit_applicant_modal','lg') !!}
    <div class="modal fade" id="add_applicant_modal"role="dialog" aria-labelledby="add_applicant_modal_label">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form role="form" id="add_applicant_form">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Applicant</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('received_at',[
                            'cols' => 3,
                            'label' => 'Date received:*',
                            'type' => 'date',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('lastname',[
                            'cols' => 3,
                            'label' => 'Last Name:*',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('firstname',[
                            'cols' => 3,
                            'label' => 'First Name:*',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('middlename',[
                            'cols' => 3,
                            'label' => 'Middle Name:*',
                        ]) !!}
                    </div>
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date_of_birth',[
                            'cols' => 2,
                            'label' => 'Birthday:*',
                            'type' => 'date',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('gender',[
                            'cols' => 2,
                            'label' => 'Sex:*',
                            'options' => \App\Swep\Helpers\Arrays::sex()
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('civil_status',[
                            'cols' => 2,
                            'label' => 'Civil Status:*',
                            'options' => \App\Swep\Helpers\Arrays::civil_status()
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('address',[
                            'cols' => 6,
                            'label' => 'Address:*',
                        ]) !!}
                    </div>

                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::select('course',[
                            'cols' => 6,
                            'label' => 'Course: *',
                            'class' => 'select2_course',
                            'options' => [],
                        ]) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('school',[
                            'cols' => 6,
                            'label' => 'School:*',
                        ]) !!}
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 position_applied">
                            <label for="school">Position(s) Applied for:</label>
                            <br>
                            <input value="{{old('position_applied')}}" type="text" name="position_applied" id="position_applied" class="form-control" value="" data-role="tagsinput" style="width:100%;">
                            <p class="text-info"><i class="fa fa-info"></i> You can add more "Position applied for" by pressing <b>ENTER</b>. </p>
                        </div>
                    </div>

                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('contact_no',[
                            'cols' => 6,
                            'label' => 'Contact No.:*',
                        ]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default pull-left" data-toggle="modal" data-target="#import_from_employee_modal"> Import data from employee</button>

                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
                </div>
            </form>

        </div>
      </div>
    </div>
    <div class="modal fade" id="import_from_employee_modal"role="dialog" aria-labelledby="import_from_employee_modal_label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Search employee</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name of employee:</label>
                        <input class="form-control" id="search_employee"  autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script type="text/javascript">

        //-----DATATABLES-----//
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        var active = '';
        applicants_tbl = $("#applicants_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route(\Illuminate\Support\Facades\Route::currentRouteName())}}',
            "columns": [
                { "data": "fullname" },
                { "data": "position_applied" },
                { "data": "course" },
                { "data": "age" },
                { "data": "received_at" },
                { "data": "sl" },
                { "data": "action" },
                { "data": "updated_at" },
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[

                {
                    "targets" : 0,
                    "class" : 'w-20p'
                },
                {
                    "targets" : 2,
                    "class" : 'w-25p'
                },
                {
                    "targets" : 1,
                    "class" : 'w-15p'
                },
                {
                    "targets" : [3,4],
                    "class" : 'text-center',
                },
                {
                    "targets" : 6,
                    "orderable" : false,
                    "class" : 'action3'
                },
                {
                    "targets" : 7,
                    "visible" : false,
                },
            ],
            "order":[[7,'desc'],[0,'asc']],
            "responsive": false,
            "initComplete": function( settings, json ) {
                $('#tbl_loader').fadeOut(function(){
                    $("#applicants_table_container").fadeIn(function () {
                        @if(request()->has('initiator') && request('initiator') == 'create')
                        introJs().start();
                        @endif
                    });
                });
            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#applicants_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#applicants_table");

        //Need to press enter to search
        $('#applicants_table_filter input').unbind();
        $('#applicants_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                applicants_tbl.search(this.value).draw();
            }
        });

        $(".dt_filter").change(function () {
            filterDT(applicants_tbl);
        })

        $(".select2_course").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_courses")}}?default=Select',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $('#add_applicant_modal')
        });

        $(".select2_course_filter").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_courses")}}?default=DontFilter',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });

        $(".select2_position_applied_filter").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_filter_position")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        })

        $(".select2_item_no_filter").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_filter_item_no")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        })

        $("#add_applicant_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.applicant.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    $(".course .select2-selection__rendered").html('Select');
                    $("#position_applied").tagsinput('removeAll');
                    notify('Applicant successfully added.');
                    active = res.slug;
                    applicants_tbl.draw(false);
                },
                error: function (res) {
                    if(res.status == 507){
                        remove_loading_btn(form);
                        Swal.fire({
                            title: 'Applicant already exists.',
                            html :'You can edit the applicant by clicking the edit button below',
                            showDenyButton: false,
                            showCancelButton: true,
                            confirmButtonText: '<i class="fa fa-edit"></i> Edit',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                let slug =res.responseJSON.message;
                                $("#add_applicant_modal").modal('hide');
                                setTimeout(function () {
                                    $("#temp_btn").attr('data',slug);
                                    $("#temp_btn").trigger('click');
                                },500)
                            } else if (result.isDenied) {
                                Swal.fire('Changes are not saved', '', 'info')
                            }
                        })
                    }else{
                        errored(form,res);
                    }
                }
            })
        })

        $("#search_employee").typeahead({
            ajax : "{{ route('dashboard.ajax.get','search_active_employees') }}",
            onSelect:function (result) {
                $("#add_user_employee_modal input[name='employee_slug']").val(result.value);
                console.log();
                $.ajax({
                    url : "{{ route('dashboard.ajax.get','search_active_employees') }}?afterTypeahead=true",
                    data : {id:result.value},
                    type: 'GET',
                    headers: {
                        {!! __html::token_header() !!}
                    },
                    success: function (res) {
                        $("#add_applicant_form input[name='lastname']").val(res.lastname);
                        $("#add_applicant_form input[name='firstname']").val(res.firstname);
                        $("#add_applicant_form input[name='middlename']").val(res.middlename);
                        $("#add_applicant_form select[name='gender']").val(res.sex);
                        $("#add_applicant_form input[name='date_of_birth']").val(res.date_of_birth);
                        $("#add_applicant_form select[name='civil_status']").val(res.civil_status);
                        $("#import_from_employee_modal").modal('hide');
                        setTimeout(function () {
                            $("#search_employee").val('');
                        },1000)
                    },
                    error: function (res) {
                        console.log(res);
                    }
                })
            },
            lookup: function (i) {
                console.log(i);
            }
        });

        $("body").on('click','.edit_applicant_btn',function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.applicant.edit","slug")}}';
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
    </script>

    <script type="text/javascript" src="{{ asset('template/plugins/bloodhound/typeahead.js') }}"></script>
    <script type="text/javascript">
        var citynames = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '{{route("dashboard.ajax.get","position_applied")}}?rand={{\Illuminate\Support\Str::random()}}',
                filter: function(list) {
                    return $.map(list, function(cityname) {
                        return { name: cityname }; });
                }
            }
        });
        citynames.initialize();

        $("#position_applied").tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: citynames.ttAdapter(),
            }
        });


        $('#add_applicant_form').keydown(function(event) {
            if (event.ctrlKey && event.keyCode === 13) {
                alert();
            }
        })

        $("body").on("click",'.add_to_sl_btn',function () {
            btn = $(this);
            let id = btn.attr('data');
            let uri = '{{route('dashboard.applicant.add_to_shortlist','slug')}}';
            uri = uri.replace('slug',id);
            Swal.fire({
                title: 'Add to short list?',
                html: btn.attr('employee'),
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check"></i> Add',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return $.ajax({
                        url : uri,
                        type: 'POST',
                        data: {'slug':id},
                        headers: {
                            {!! __html::token_header() !!}
                        },
                    })
                        .then(response => {
                            return  response;
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    notify('Applicant was added to the short list.','success');
                    active = result.value;
                    applicants_tbl.draw(false);
                }
            })

        })

        $("body").on("click",'.remove_from_sl_btn',function () {
            btn = $(this);
            let id = btn.attr('data');
            let uri = '{{route('dashboard.applicant.remove_to_shortlist','slug')}}';
            uri = uri.replace('slug',id);
            Swal.fire({
                title: 'Remove from short list?',
                html: btn.attr('employee'),
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check"></i> Add',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return $.ajax({
                        url : uri,
                        type: 'POST',
                        data: {'slug':id},
                        headers: {
                            {!! __html::token_header() !!}
                        },
                    })
                        .then(response => {
                            return  response;
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    notify('Applicant was removed from the short list.','success');
                    active = result.value;
                    applicants_tbl.draw(false);
                }
            })

        })

        $('.bootstrap-tagsinput input').on('keypress', function(e){
            if (e.keyCode == 13){
                e.keyCode = 188;
                e.preventDefault();
            };
        });
    </script>

@endsection

