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
                        <button type="submit" id="" class="btn btn-primary btn-sm"> <i class="fa fa-refresh"></i> Days </button>
                    </div>
                    <div class="btn-group pull-right">
                        <button type="button" id="recompute_btn" class="btn btn-primary btn-sm"> <i class="fa fa-refresh"></i> Recompute </button>
                    </div>
                </div>
                <div class="box-body" id="payroll_table">

                    @include('dashboard.hru.payroll_preparation.RATA.preview',[
                        'payrollMaster' => $payrollMaster,
                    ])
                </div>
            </div>

        </form>
    </section>

@endsection


@section('modals')
    
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

        $("#prepare_payroll_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.payroll_preparation.updateRataDed",$payrollMaster->slug)}}';
            loading_btn(form);
            $.ajax({
                url : uri,
                data: form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    recompute();
                    toast('success','Number of Days updated!','Saved');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        } )


    </script>
@endsection