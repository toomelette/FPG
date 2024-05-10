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
            </div>
        </div>
        <form id="prepare_payroll_form">
            <div class="box box-solid">
                <div class="box-header">
                    <div class="btn-group pull-right">
                        <button type="button" data-target="#upload_modal" data-toggle="modal" class="btn btn-default btn-sm"> <i class="fa fa-folder-open"></i> Upload Excel File </button>

                        <button type="button" id="recompute_btn" class="btn btn-primary btn-sm"> <i class="fa fa-refresh"></i> Recompute </button>
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
                            'SURRECO' => 'SURRECO',
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
        function recompute(){
            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?recompute=true';
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#payroll_table").html(res);
                },
                error: function (res) {
                    toast('warning','Error recomputing.','Error!');
                }
            })
        }
        $("body").on("click","#recompute_btn",function () {
            recompute();
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
                    recompute();
                    toast('info','Excel data successfully imported','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection