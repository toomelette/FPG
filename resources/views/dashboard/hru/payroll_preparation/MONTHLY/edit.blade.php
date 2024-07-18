@extends('layouts.admin-master')

@section('content')

@endsection
@section('content2')

    <section class="content">
        <div class="well well-sm">
            <div class="row">
                <div class="col-md-3">
                    <dl>
                        <dt>Payroll Date:</dt>
                        <dd>{{Helper::dateFormat($payrollMaster->date,'F d, Y')}}</dd>
                    </dl>
                </div>
                <div class="col-md-3">
                    <dl>
                        <dt>Payroll Type:</dt>
                        <dd>{{$payrollMaster->type}}</dd>
                    </dl>
                </div>
                <div class="col-md-3">
                    <dl>
                        <dt>Employees:</dt>
                        <dd>{{$payrollMaster->payrollMasterEmployees->count()}}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm edit-signatories-btn" data-toggle="modal" data-target="#edit-signatories-modal"> <i class="fa fa-edit"></i> Edit Signatories </button>
                </div>
                <div class="btn-group pull-right">
                    <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'MONTHLY'])}}" target="_blank" class="btn btn-default btn-sm"> <i class="fa fa-print"></i> Print Payroll </a>
                    <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'PAYSLIP_ALL'])}}" target="_blank" class="btn btn-default btn-sm"> <i class="fa fa-print"></i> Print Payslips </a>
                    <button type="button" id="lock_btn" class="btn btn-default btn-sm" action="{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"> <span class="text-danger"><i class="fa fa-{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"></i> {{$payrollMaster->is_locked == 1 ? 'Unlock':'Lock'}} </span></button>
                    <button type="button" id="upload_btn" data-target="#upload_modal" data-toggle="modal" class="btn btn-default btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-folder-open"></i> Upload Excel File </button>
                    <button type="button" id="recompute_btn" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recompute </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <p class="text-info" style="padding-left: 10px"><i class="fa fa-info-circle"></i> Click on the employee's name to print individual payslip or to view employee details.</p>
                </div>
                <div class="col-md-3" style="margin-bottom: 5px">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Search:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-sm" id="search" placeholder="Search employee" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body" id="payroll_table">

                @include('dashboard.hru.payroll_preparation.MONTHLY.preview',[
                    'payrollMaster' => $payrollMaster,
                ])
            </div>
        </div>

    </section>

@endsection


@section('modals')
    <x-html.modal size="md" id="edit-signatories-modal"/>
    <div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal_label">
      <div class="modal-dialog modal-sm" role="document">
          <form id="upload_form">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload Excel</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                    {!! \App\Swep\ViewHelpers\__form2::select('type',[
                       'label' => 'Type:',
                       'cols' => 12,
                       'options' => [
                            'GSIS' => 'GSIS',
                            'HDMF' => 'HDMF',
                            'SURECCO' => 'SURECCO',
                            'SUDEMUPCO' => 'SUDEMUPCO',
                            'SUGAREAP' => 'SUGAREAP',
                            'AR' => 'AR',
                        ]
                   ]) !!}
                    {!! \App\Swep\ViewHelpers\__form2::textbox('file',[
                        'label' => 'Type:',
                        'cols' => 12,
                        'type' => 'file'
                    ]) !!}
                </div>
              </div>
              <div class="modal-footer">
                 <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-check"></i> Upload</button>
              </div>
            </div>
          </form>
      </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        function recompute(btn){
            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?recompute=true';
            wait_this_button(btn,'Recompute');
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#payroll_table").html(res);
                    unwait_this_button(btn);
                    toast('info','Payroll successfully recomputed.','Success!');
                },
                error: function (res) {
                    toast('warning',res.responseJSON.message,'Error!');
                    unwait_this_button(btn);

                }
            })
        }
        $("body").on("click","#recompute_btn",function () {
            let btn = $(this);
            recompute(btn);
        })
        
        $("#upload_form").submit(function (e) {
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

        $("#lock_btn").click(function (){
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
                            let lockBnt = $("#lock_btn");
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