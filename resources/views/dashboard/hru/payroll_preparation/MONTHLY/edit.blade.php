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
        <form id="prepare_payroll_form">
            <div class="box box-solid">
                <div class="box-header">
                    <div class="btn-group pull-right">
                        <button type="button"  class="btn btn-default btn-sm"> <i class="fa fa-print"></i> Print Payroll </button>
                        <button type="button" id="lock_btn" class="btn btn-default btn-sm" action="{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"> <span class="text-danger"><i class="fa fa-{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"></i> {{$payrollMaster->is_locked == 1 ? 'Unlock':'Lock'}} </span></button>
                        <button type="button" id="upload_btn" data-target="#upload_modal" data-toggle="modal" class="btn btn-default btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-folder-open"></i> Upload Excel File </button>
                        <button type="button" id="recompute_btn" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recompute </button>
                    </div>
                </div>
                <div class="box-body" id="payroll_table">

                    @include('dashboard.hru.payroll_preparation.MONTHLY.preview',[
                        'payrollMaster' => $payrollMaster,
                    ])
                </div>
            </div>

        </form>
    </section>

@endsection


@section('modals')
    <div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal_label">
      <div class="modal-dialog modal-sm" role="document">
          <form id="upload_form">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
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
    </script>
@endsection