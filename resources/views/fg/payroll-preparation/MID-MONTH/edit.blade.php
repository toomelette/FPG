@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.card>
        <div class="row">
            <div class="col-md-3">
                <dl class="mb-0">
                    <dt>Payroll Date:</dt>
                    <dd>{{Helper::dateFormat($payrollMaster->date,'F d, Y')}}</dd>
                </dl>
            </div>
            <div class="col-md-3">
                <dl class="mb-0">
                    <dt>Payroll Type:</dt>
                    <dd>{{$payrollMaster->type}}</dd>
                </dl>
            </div>
            <div class="col-md-3">
                <dl class="mb-0">
                    <dt>Employees:</dt>
                    <dd>{{$payrollMaster->payrollEmployees->count()}}</dd>
                </dl>
            </div>
        </div>
    </x-adminkit.html.card>
    <x-adminkit.html.card body-class="pt-0">
        <x-slot:title>
            <div class="btn-group">

                <button type="button" class="btn btn-outline-secondary btn-sm edit-signatories-btn" data-bs-toggle="modal" data-bs-target="#edit-signatories-modal"> <i class="fa fa-edit"></i> Edit Signatories </button>
                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#print-offcanvas" aria-controls="offcanvasRight"><i class="fa fa-print"></i> Print</button>
                <button type="button" id="update-employees-data-btn" class="btn btn-outline-secondary btn-sm visually-hidden" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recapture Employees Data </button>

                <button type="button" id="lock-btn" class="btn btn-outline-secondary btn-sm" action="{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"> <span class="text-danger"><i class="fa fa-{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"></i> {{$payrollMaster->is_locked == 1 ? 'Unlock':'Lock'}} </span></button>

            </div>
            <div class="btn-group float-end">
                <button type="button" id="fetch-table-btn" class="btn btn-outline-secondary btn-sm"> Fetch </button>

                <button type="button" id="ad-employee-btn" data-bs-target="#add-employee-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-plus"></i> Add Employee </button>
                <button type="button" id="submit-form-btn" data-bs-target="#add-employee-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-check"></i> Submit </button>

{{--                <a type="button" href="{{route('dashboard.payroll_refund.index',$payrollMaster->slug)}}"  class="btn btn-outline-secondary btn-sm"> <i class="fa fa-money-bill-transfer"></i> Refunds </a>--}}
{{--                <button type="button" data-bs-target="#other-actions-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-gear"></i> Other Actions </button>--}}
{{--                <button type="button" id="upload-btn" data-bs-target="#upload-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-folder-open"></i> Upload Excel File </button>--}}
{{--                <button type="button" id="recompute-btn" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recompute </button>--}}
            </div>
        </x-slot:title>

        <div class="row">
            <div class="col-md-9">
                <p class="text-info" style="padding-left: 10px"><i class="fa fa-info-circle"></i> Click on the employee's name to print individual payslip or to edit payroll template.</p>
            </div>
            <div class="col-md-3" style="margin-bottom: 5px">
                <div class="mb-1 row">
                    <label class="col-form-label col-sm-3 text-sm-end">Search:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="search" placeholder="Search employee" autocomplete="off">
                    </div>
                </div>

            </div>
        </div>
        <div class="box-body">
            <form id="payroll-form">
                <table id="payroll-table" class="table table-sm table-bordered table-striped">
                    <thead>

                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </form>
        </div>

        <div class="text-center visually-hidden" style="padding: 8%" id="loading-placeholder">
            <i class="fa fa-circle-notch fa-spin" style="font-size: 50px"></i>
        </div>
    </x-adminkit.html.card>


    <div id="payroll-group-container" style="display: none">
        <div style="text-align: left; overflow: hidden">
            <div class="row">
                <form class="select-form" id="replaceMe">
                    <x-forms.checkbox type="checkbox" label="Payroll Group" name="payrollGroupsSelected" cols="12" :options="\App\Swep\Helpers\Arrays::payrollGroups()" id="replaceMe"/>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            autonumGlobalInstances['payroll'] = autonumGlobalInstances['payroll'] || {};
            fetchTable();
        });

        function fetchTable(){
            let uri = '{{route("payroll-preparation.edit",$payrollMaster->uuid)}}?fetchTable';
            let $table = $("#payroll-table");

            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {

                    $table.find("thead").html(res.header);
                    $.each(res.body,function (i,value){
                        let key = value.payroll_employee_id;
                        // add employee if not existing
                        if (!autonumGlobalInstances['payroll'][value.employee_uuid]) {
                            autonumGlobalInstances['payroll'][value.employee_uuid] = {};
                        }

                        let $tr = $table.find('tbody tr#'+key);
                        if ($tr.length) {
                            $tr.html(value.view);
                        } else {
                            // Does not exist
                            $table.find('tbody').append('<tr id="'+key+'" data-employee-uuid="'+value.employee_uuid+'">'+value.view+'</tr>');
                        }

                    })


                    $(".payroll-autonum").each(function (){
                        let $e = $(this);
                        let id = $e.attr('id');
                        let employeeUUID = $e.closest('tr').data('employee-uuid');
                        let code = $e.data('code');

                        // Ensure the employee object exists
                        autonumGlobalInstances['payroll'][employeeUUID] =
                            autonumGlobalInstances['payroll'][employeeUUID] || {};

                        // Add or update the code
                        autonumGlobalInstances['payroll'][employeeUUID][code] = new AutoNumeric('#'+id,autonum_settings_simple);
                    })


                },
                error: function (res) {

                }
            })
        }
        $("body").on("click","#fetch-table-btn",function () {
            fetchTable();
        })

        $("body").on("click",".fetch-template-btn",function () {
            let btn = $(this);
            let code = btn.data('code');
            load_modal2(btn);
            let uri = '{{route("payroll-preparation.edit",$payrollMaster->uuid)}}?fetchTemplate='+code;
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $.each(res,function (employeeUUID,amount){
                        console.log(employeeUUID);
                        console.log(code);
                        if(typeof autonumGlobalInstances['payroll'][employeeUUID][code] !== 'undefined'){
                            autonumGlobalInstances['payroll'][employeeUUID][code].set(sanitizeAutonum(amount));
                        }

                    })

                },
                error: function (res) {

                }
            })
        })

        $("#submit-form-btn").click(function(){
            $("#payroll-form").submit();
        });
        $("#payroll-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("payroll-preparation.update", $payrollMaster->uuid)}}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Payroll successfully saved.','Success');
                    fetchTable();
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("#search").keyup(function (e){
            search();
        })
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("payroll-employees-table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        function recompute(btn){
            let uri = '{{route("payroll-preparation.edit",$payrollMaster->uuid)}}?recompute=true';
            let placeholder = $("#loading-placeholder");
            let table = $("#payroll-table");
            table.addClass('visually-hidden');
            placeholder.removeClass('visually-hidden');
            wait_this_button(btn,'Recompute');
            $("#search").val('');
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    table.html(res);
                    unwait_this_button(btn);
                    toast('info','Payroll successfully recomputed.','Success!');
                    table.removeClass('visually-hidden');
                    placeholder.addClass('visually-hidden');
                },
                error: function (res) {
                    unwait_this_button(btn);
                    toast('warning',res.responseJSON.message,'Error!');
                    table.removeClass('visually-hidden');
                    placeholder.addClass('visually-hidden');
                }
            })
        }
        $("body").on("click","#recompute-btn",function () {
            let btn = $(this);
            recompute(btn);
        })

        $("body").on("click","#update-employees-data-btn",function () {
            let btn = $(this);
            let uri = '{{route("payroll-preparation.update",$payrollMaster->uuid)}}?updateEmployeesData=true';
            wait_this_button(btn,'Please wait');
            $("#search").val('');
            $.ajax({
                url : uri,
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    unwait_this_button(btn);
                    toast('info','Employee data successfully updated.','Success!');

                },
                error: function (res) {
                    unwait_this_button(btn);
                    toast('warning',res.responseJSON.message,'Error!');
                }
            })
        })
        $("#upload-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            var formData = new FormData(this);
            let uri = '{{route("payroll-preparation.update",$payrollMaster->uuid)}}?import=true';
            loading_btn(form);
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
                    recompute($("#recompute_btn"));
                    toast('info','Excel data successfully imported','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-signatories-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("payroll-preparation.edit",$payrollMaster->uuid)}}?signatories=true';
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



        $("body").on("click",".employee-options-btn",function (){
            let btn = $(this);
            load_offcanvas(btn);
            $.ajax({
                url : '{{route("payroll-preparation.edit",$payrollMaster->uuid)}}?employee',
                data : {
                    employee : btn.attr('emp-slug'),
                    employeePayrollListSlug : btn.attr('data'),
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_offcanvas(btn,res);
                },
                error: function (res) {
                    populate_offcanvas_error(res);
                }
            })
        })

        $("#edit-bulk-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("payroll-preparation.update",$payrollMaster->uuid)}}?bulk',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('info','MAP deductions successfully updated.','Success!');
                    recompute($("#recompute_btn"));
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-deduction",function(){
            let btn = $(this);
            let employeeListSlug = btn.parent('tr').attr('data');
            let slug = btn.attr('data');
            let deductionCode = btn.attr('deduction-code');
            let uri = '{{route("payroll-preparation.edit",$payrollMaster->uuid)}}?editDeduction';
            load_modal2(btn);
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                data: {
                    employeeListSlug : employeeListSlug,
                    slug : slug,
                    deductionCode : deductionCode,
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        $("body").on('click','.require-dialog',function (e){
            e.preventDefault();
            let link = $(this).attr('href');
            let target = $(this).attr('target');
            let newId = 'tempId'+makeId(6);
            Swal.fire({
                title: "Select payroll group",
                html: $("#payroll-group-container").html().replaceAll('replaceMe',newId),
                showCancelButton: true,
                confirmButtonText: "<i class='fa fa-print'></i> Print",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    if(link.includes('?')){
                        window.open(link+'&'+$("#"+newId).serialize(), target);
                    }else{
                        window.open(link+'?'+$("#"+newId).serialize(), target);
                    }
                }
            });
        });

        $("#add-employee-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            var formData = new FormData(this);
            let uri = '{{route("payroll-preparation.update",$payrollMaster->uuid)}}?addEmployee=true';
            loading_btn(form);
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
                    succeed(form,false,false);
                    toast('info','Employee successfully added. Please wait.','Updated');
                    location.reload();
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })


    </script>
@endsection