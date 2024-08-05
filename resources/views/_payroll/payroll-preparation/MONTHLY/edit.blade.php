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
                    <dd>{{$payrollMaster->payrollMasterEmployees->count()}}</dd>
                </dl>
            </div>
        </div>
    </x-adminkit.html.card>
    <x-adminkit.html.card body-class="pt-0">
        <x-slot:title>
            <button type="button" class="btn btn-outline-secondary btn-sm edit-signatories-btn" data-bs-toggle="modal" data-bs-target="#edit-signatories-modal"> <i class="fa fa-edit"></i> Edit Signatories </button>
            <div class="btn-group float-end">
                <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'MONTHLY'])}}" target="_blank" class="btn btn-outline-secondary btn-sm"> <i class="fa fa-print"></i> Print Payroll </a>
                <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'PAYSLIP_ALL'])}}" target="_blank" class="btn btn-outline-secondary btn-sm"> <i class="fa fa-print"></i> Print Payslips </a>
                <button type="button" id="lock-btn" class="btn btn-outline-secondary btn-sm" action="{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"> <span class="text-danger"><i class="fa fa-{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"></i> {{$payrollMaster->is_locked == 1 ? 'Unlock':'Lock'}} </span></button>
                <button type="button" id="upload-btn" data-bs-target="#upload-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-folder-open"></i> Upload Excel File </button>
                <button type="button" id="recompute-btn" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recompute </button>
            </div>
        </x-slot:title>

        <div class="row">
            <div class="col-md-9">
                <p class="text-info" style="padding-left: 10px"><i class="fa fa-info-circle"></i> Click on the employee's name to print individual payslip or to view employee details.</p>
            </div>
            <div class="col-md-3" style="margin-bottom: 5px">
                <div class="mb-1 row">
                    <label class="col-form-label col-sm-3 text-sm-end">Search:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="search" placeholder="Search employee" autocomplete="off">
                    </div>
                </div>

            </div>
        </div>
        <div class="box-body" id="payroll-table">

            @include('_payroll.payroll-preparation.MONTHLY.preview',[
                'payrollMaster' => $payrollMaster,
            ])
        </div>

        <div class="text-center visually-hidden" style="padding: 8%" id="loading-placeholder">
            <i class="fa fa-circle-notch fa-spin" style="font-size: 50px"></i>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-signatories-modal"/>
    <x-adminkit.html.modal-template id="upload-modal" size="sm" form-id="upload-form">
        <x-slot:title>
            Upload deductions
        </x-slot:title>
        <div class="row mb-2">
            <x-forms.select label="Type" name="type" cols="12" :options="[
                    'GSIS' => 'GSIS',
                    'HDMF' => 'HDMF',
                    'SURECCO' => 'SURECCO',
                    'SUDEMUPCO' => 'SUDEMUPCO',
                    'SUGAREAP' => 'SUGAREAP',
                    'AR' => 'AR',
                ]"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="File" name="file" cols="12" type="file"/>

        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Upload</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
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
            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?recompute=true';
            let placeholder = $("#loading-placeholder");
            let table = $("#payroll-table");
            table.addClass('visually-hidden');
            placeholder.removeClass('visually-hidden');
            wait_this_button(btn,'Recompute');
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
                    toast('warning',res.responseJSON.message,'Error!');
                    unwait_this_button(btn);
                    table.removeClass('visually-hidden');
                    placeholder.addClass('visually-hidden');
                }
            })
        }
        $("body").on("click","#recompute-btn",function () {
            let btn = $(this);
            recompute(btn);
        })

        $("#upload-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            var formData = new FormData(this);
            let uri = '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?import=true';
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
            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?signatories=true';
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


        $("#lock-btn").click(function (){
            let btn = $(this);
            let url = '{{route('dashboard.payroll_preparation.updateLockStatus',[$payrollMaster->slug,"status"])}}';
            let text;
            let action = btn.attr('action');
            if(btn.attr('action') === 'lock'){
                text = 'Lock';
                html = 'This payroll cannot be edited anymore unless unlocked.';
            }else{
                text = 'Unlock';
                html = 'Actions will be enabled after unlocking.';
            }
            url = url.replace('status',btn.attr('action'));
            Swal.fire({
                title: text+' this payroll?',
                // input: 'text',
                html: html,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-'+btn.attr('action')+'"></i> '+text,
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return $.ajax({
                        url : url,
                        type: 'POST',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res){
                            let lockBnt = $("#lock-btn");
                            if(res === 'locked'){
                                $("#upload_btn").attr('disabled','disabled');
                                $("#recompute_btn").attr('disabled','disabled');
                                lockBnt.attr('action','unlock');
                                lockBnt.html('<span class="text-danger"><i class="fa fa-unlock">  </i> Unlock</span>' );
                            }else{
                                $("#upload_btn").removeAttr('disabled');
                                $("#recompute_btn").removeAttr('disabled');
                                lockBnt.attr('action','lock');
                                lockBnt.html('<span class="text-danger"><i class="fa fa-lock">  </i> Lock</span>' );
                            }
                        }
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
                    Swal.fire({
                        title: 'Payroll successfully '+action+'ed',
                        icon : 'success',
                    })
                }
            })
        })

        $("body").on("click",".employee-options-btn",function (){
            let btn = $(this);
            Swal.fire({
                title: btn.html(),
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "<i class='fa fa-print'></i> Print Payslip",
                denyButtonText: "<i class='fa fa-user'></i> View Employee",
                confirmButtonColor : '#3c8dbc',
                denyButtonColor : '#3da162',
                html : btn.attr('content')
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let printRoute = '{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'PAYSLIP_ALL'])}}?employeeList='+btn.attr('data');
                    window.open(printRoute, "popupWindow", "width=1200, height=600, scrollbars=yes");
                } else if (result.isDenied) {
                    window.open('{{route('dashboard.employee.index')}}?find='+btn.attr('emp-no'), '_blank').focus();
                }
            });
        });
    </script>
@endsection