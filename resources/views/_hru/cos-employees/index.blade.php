@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Employees</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success "  data-bs-target="#print-multiple-modal" data-bs-toggle="modal"><i class="fa fa-print"></i> Print multiple</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end">
                        <button class="btn btn-sm btn-outline-secondary upload-excel-btn"  data-bs-target="#upload-excel-modal" data-bs-toggle="modal"><i class="fa fa-file-excel"></i> Upload Excel</button>
                        <button class="btn btn-sm btn-outline-secondary add-multiple-employee-btn"  data-bs-target="#add-multiple-employee-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> Add Multiple</button>
                        <button class="btn btn-sm btn-primary "  data-bs-target="#add-employee-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> Add Employee</button>
                    </div>
                </div>
            </div>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="employees-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Employee Name</th>
                <th>Position</th>
                <th>Resp Center</th>
                <th>Assignment</th>
                <th>Salary</th>
                <th>Evaluation Form</th>
                <th>Print Contract</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection
@php
    $usedRcs = $cos->employees->pluck('resp_center')->unique();
    $usedRcs = \App\Models\PPU\PPURespCodes::query()->whereIn('rc_code',$usedRcs)->get();
@endphp

@section('modals')
    <x-adminkit.html.modal id="add-multiple-employee-modal" size="85"/>
    <x-adminkit.html.modal id="edit-cos-employee-modal" size="sm"/>
    <x-adminkit.html.modal-template id="add-employee-modal" form-id="add-employee-form" size="sm">
        <x-slot:title>Add Employee</x-slot:title>
        <div class="row">
            <x-forms.select label="Employee" name="employee_slug" cols="12" :options="[]" id="select-employee"/>
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal-template id="print-multiple-modal" form-id="print-multiple-form" form-target="_blank" size="sm">
        <x-slot:title>Print Multiple</x-slot:title>
        <div class="row">
            <input name="printMultiple" value="true" hidden="">
            @forelse($usedRcs as $usedRc)
                <div class="col-md-12">
                    <label class="form-check">
                        <input class="form-check-input" name="rcs[]" type="checkbox" value="{{$usedRc->rc_code}}">
                        <span class="form-check-label">
                            {{$usedRc->desc}}
                        </span>
                    </label>
                </div>
            @empty
            @endforelse
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-print"></i> Print</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

    <x-adminkit.html.modal-template id="upload-excel-modal" form-id="upload-excel-form" size="sm">
        <x-slot:title>Upload Excel</x-slot:title>
        <div class="row">
            <x-forms.input label="Employee" type="file" name="file" cols="12"/>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="update" type="checkbox" value="">
                    <span class="form-check-label">
                    Auto update employees database.
                </span>
                </label>
            </div>
        </div>
        <div id="error-cont" style="display: none" class="mt-3">
            <div class="alert alert-danger" role="alert">
                <div class="alert-message">
                    <span class="message"><strong>Hello there!</strong></span>
                    <div id="more-text">

                    </div>
                </div>
            </div>
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>

    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        employeesTbl = $("#employees-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                //{ data : "employee.full.LFEMi" , name: 'employee.fullname' },
                //{ data : "employee.position" , name: 'employee.position' },
                { data : "employee_fullname" },
                { data : "employee.position" , name: 'employee.position' },
                { data : "employee.responsibility_center.desc"  , name: 'employee.responsibilityCenter.desc' },
                { data : "cos_assignment" },
                {
                    data : "employee.monthly_basic" ,
                    name: 'employee.monthly_basic' ,
                    render : function (data,type,row,meta){
                        return $.number(data,2);
                    }
                },
                { data : "evaluation_path" , name: 'evaluation_path' },
                { data : "print_contract"},
                { data : "actions"},
            ],
            buttons : [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs :[
                {
                    targets: '_all',
                    class : 'align-top'
                },
                {
                    targets: [4],
                    class : 'text-end',
                },

            ],
            rowGroup: {
                dataSrc: 'employee.responsibility_center.desc'
            },
            order:[[2,'asc'],[0,'asc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        employeesTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#select-employee").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","new-employee-for-cos")}}?cos={{$cos->slug}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $("#add-employee-modal"),
        });

        $("#add-employee-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.cos_employees.store",$cos->slug)}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Employee successfully added.','Success');
                    active = res.slug;
                    employeesTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-cos-employee-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.cos_employees.edit","slug")}}';
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

        $("body").on("change",".allow-print",function (){
            let t = $(this);
            let checked = t.prop('checked');
            let data = t.attr('data');
            let uri = '{{route("dashboard.cos_employees.update","slug")}}?allowPrint';
            uri = uri.replace('slug',data);
            $.ajax({
                url : uri,
                data : {
                    hr_cos_employees_slug : data,
                    checked : checked,
                },
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('info','Employee successfully updated.','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        
        $("body").on("click",".add-multiple-employee-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.cos_employees.create",request()->route('slug'))}}';
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

        $("#upload-excel-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            var formData = new FormData(this);
            let uri = '{{route("dashboard.cos_employees.store",$cos->slug)}}?import=true';
            loading_btn(form);
            $("#error-cont").hide();
            $.ajax({
                url : uri,
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Excel data successfully imported','Updated');
                    employeesTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                    if(res.status === 515){
                        let msg = JSON.parse(res.responseJSON.message);
                        console.log(msg);
                        $("#error-cont .message strong").html(msg.message);
                        let list  = '<ul>';
                        $.each(msg.dataArray,function (i,v){
                            list = list + '<li>'+i+' - '+v+'</li>';
                        })
                        list = list + '</ul>'
                        $("#more-text").html(list);
                        $("#error-cont").show();
                    }
                }
            })
        })
    </script>
@endsection