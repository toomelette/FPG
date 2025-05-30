@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard.payroll_preparation.edit',$payrollMaster->slug)}}">Payroll Preparation</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Refunds</li>
                </ol>
            </nav>

        </x-slot:title>
    </x-adminkit.html.page-title>

    <div class="row">
        <div class="col-4">
            <x-adminkit.html.card body-class="pt-0">
                <x-slot:title class="pb-0">
                    Deductions
                </x-slot:title>
                <div style="overflow-y: scroll; height:72vh" id="deduction-list-container" class="side-list">
                    <ul class="list-group list-group-flush" id="deduction-list">
                        @forelse($groupedPayrollDeductions as $deductionCode => $payrollDeduction)
                            <li class="list-group-item pt-2 pb-2 ps-1 deduction-item item" data="{{$deductionCode}}"><strong>{{$deductionCode}}</strong> <small>{{$payrollDeduction->first()->deduction->description}}</small> <span class="float-end">{{$payrollDeduction->count()}}</span></li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-8">
            <x-adminkit.html.card style="min-height:78.5vh">
                <div id="employees">
                    <div class="text-center" style="padding-top: 30vh">
                        <h1><i class="fa fa-info-circle"></i></h1>
                        <p>Select deduction from the list</p>
                    </div>
                </div>
                <div id="employees-placeholder" class="visually-hidden">
                    <div class="text-center" style="padding-top: 30vh">
                        <h1 style="font-size: 50px"><i class="fa fa-circle-notch fa-spin"></i></h1>
                    </div>
                </div>
            </x-adminkit.html.card>
        </div>
    </div>

@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-refund-modal" size="sm"/>
@endsection

@section('scripts')
<script type="text/javascript">
    let dataTablesArray = [];
    let active = '';
    let activeTable = '';
    $("#deduction-list .deduction-item").click(function (){
        let items = $("#deduction-list .deduction-item");
        let deductionCode = $(this).attr('data');
        items.each(function (){
            $(this).removeClass('selected');
        });
        $("#employees").addClass('visually-hidden');
        $("#employees-placeholder").removeClass('visually-hidden');

        let url = '{{route("dashboard.payroll_refund.index",$payrollMaster->slug)}}?show';
        $("#employees").html('');
        $.ajax({
            url : url,
            type: 'GET',
            data: {
                deductionCode : deductionCode,
            },
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                $("#employees").html(res);
                $("#employees").removeClass('visually-hidden');
                $("#employees-placeholder").addClass('visually-hidden');
            },
            error: function (res) {

            }
        })
        $(this).addClass('selected');
    })

    $("body").on("click",".edit-refund-btn",function () {
        let btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.payroll_refund.edit","slug")}}';
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
@endsection