@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Hazard Pay (PRC)</x-slot:title>
        <x-slot:subtitle>Monthly Payroll</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
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
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-sm edit-signatories-btn" data-bs-toggle="modal" data-bs-target="#edit-signatories-modal"> <i class="fa fa-edit"></i> Edit Signatories </button>
                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#print-offcanvas" aria-controls="offcanvasRight"><i class="fa fa-print"></i> Print</button>
                <button type="button" id="update-employees-data-btn" class="btn btn-outline-secondary btn-sm visually-hidden" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recapture Employees Data </button>

                <button type="button" id="lock-btn" class="btn btn-outline-secondary btn-sm" action="{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"> <span class="text-danger"><i class="fa fa-{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"></i> {{$payrollMaster->is_locked == 1 ? 'Unlock':'Lock'}} </span></button>

            </div>
            <div class="btn-group float-end">
                <button type="button" id="recompute-btn" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recompute </button>
            </div>
        </x-slot:title>

        <div class="row">
            <div class="col-md-9">
                <p class="text-info" style="padding-left: 10px"><i class="fa fa-info-circle"></i> You may double click EXCLUDED DAYS column to update parameter.</p>
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
            @include('_payroll.payroll-preparation.HAZARDPRC.preview',[
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

    <x-adminkit.html.offcanvas class="end asdasd" id="offcanvasLeft">
        <x-slot:title>
            Employee Options
        </x-slot:title>
    </x-adminkit.html.offcanvas>

    <x-adminkit.html.offcanvas class="end" id="print-offcanvas">
        <x-slot:title>
            Print Options
        </x-slot:title>
        <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'HAZARDPRC'])}}" target="_blank" class="btn btn-outline-primary btn-sm col-12 mb-2"> <i class="fa fa-print"></i> Payroll Summary</a>
        <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'HAZARDPRC-ABSTRACT'])}}" target="_blank" class="btn btn-outline-primary btn-sm col-12 mb-2"> <i class="fa fa-print"></i> Payroll Abstract</a>

    </x-adminkit.html.offcanvas>
@endsection

@section('scripts')
    <script type="text/javascript">
        function recompute(btn){
            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?recompute=true';
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

        $("body").on("dblclick",".double-click-edit",function (){
            let td = $(this);
            td.find('.text-ph').hide();
            td.find('.no-of-days-form').show();
            td.find('.no-of-days-form').find('input[name="ineligible_days"]').focus();
        });

        $("body").on('submit','.no-of-days-form',function (e) {
            e.preventDefault();
            let form = $(this);
            let slug = form.parents('tr').attr('data');
            let uri = '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?updateHazardDays=true&employeeListSlug='+slug;
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('info','No. of days successfully updated.','Updated');
                    $("tr[data='"+slug+"']").html(res);
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
            load_offcanvas(btn);
            $.ajax({
                url : '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?employee',
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
    </script>
@endsection