@extends('adminkit.master')

@section('content2')
    @php
        $daysInMonthArray = [];
        $totalNoOfDaysInMonth = Carbon::parse($payrollMaster->date)->daysInMonth;
        $yearMonth = Carbon::parse($payrollMaster->date)->format('Y-m-');

        for ($i = 1; $i <= $totalNoOfDaysInMonth; $i ++){
            $padded = Str::of($i)->padLeft(2,'0')->toString();
            $currDate = Carbon::parse($yearMonth.$padded);
            $daysInMonthArray[$i] = $currDate->isWeekday();
        }


    @endphp
    <x-adminkit.html.page-title>
        <x-slot:title>Differential - Year End Bonus</x-slot:title>
        <x-slot:subtitle>Payroll</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="row">
            <div class="col-md-3">
                <dl class="mb-0">
                    <dt>Payroll Date:</dt>
                    <dd>{{Helper::dateFormat($payrollMaster->date,'F Y')}}</dd>
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

    <form id="diff-form">
        <x-adminkit.html.card body-class="pt-0">
            <x-slot:title>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary btn-sm edit-signatories-btn" data-bs-toggle="modal" data-bs-target="#edit-signatories-modal"> <i class="fa fa-edit"></i> Edit Signatories </button>
                    <button class="btn btn-success btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#print-offcanvas" aria-controls="offcanvasRight"><i class="fa fa-print"></i> Print</button>
                    <button type="button" id="update-employees-data-btn" class="btn btn-outline-secondary btn-sm visually-hidden" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recapture Employees Data </button>

                    <button type="button" id="lock-btn" class="btn btn-outline-secondary btn-sm" action="{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"> <span class="text-danger"><i class="fa fa-{{$payrollMaster->is_locked == 1 ? 'unlock':'lock'}}"></i> {{$payrollMaster->is_locked == 1 ? 'Unlock':'Lock'}} </span></button>

                </div>
                <div class="btn-group float-end">
                    <button type="button" id="ad-employee-btn" data-bs-target="#add-employee-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-plus"></i> Add Employee </button>
                    <button type="button" id="upload-btn" data-bs-target="#upload-modal" data-bs-toggle="modal" class="btn btn-outline-secondary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-folder-open"></i> Upload Excel File </button>
                    {{--                <button type="button" id="recompute-btn" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Recompute </button>--}}
                    <button type="submit" class="btn btn-primary btn-sm" {{$payrollMaster->is_locked == 1 ? 'disabled':''}}> <i class="fa fa-refresh"></i> Save & Recompute </button>

                </div>
            </x-slot:title>

            <div class="row">
                <div class="col-md-9">
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
                @include('_payroll.payroll-preparation.DIFF-YEB.preview',[
                    'payrollMaster' => $payrollMaster,
                ])
            </div>

            <div class="text-center visually-hidden" style="padding: 8%" id="loading-placeholder">
                <i class="fa fa-circle-notch fa-spin" style="font-size: 50px"></i>
            </div>
        </x-adminkit.html.card>
    </form>
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
@php
    $nonExistingEmployees = \App\Models\Employee::query()
        ->permanent()
        ->applyProjectId()
        ->whereHas('responsibilityCenter')
        ->whereHas('plantilla')
        ->whereNotIn('slug',$payrollMaster->payrollMasterEmployees->pluck('employee_slug'))
        ->orderBy('lastname')
        ->get()
        ->map(function ($data){
            return [
                'id' => $data->slug,
                'text' => $data->full['LFEMi']
            ];
        });
@endphp

@section('modals')
    <x-adminkit.html.modal id="edit-signatories-modal"/>
    <x-adminkit.html.modal id="edit-deduction-modal" size="sm"/>


    <x-adminkit.html.modal-template id="add-employee-modal" size="sm" form-id="add-employee-form">
        <x-slot:title>
            Add Employee
        </x-slot:title>
        <div class="alert alert-warning" role="alert">
            <div class="alert-message">
                Page will reload after adding an employee.
            </div>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Employee" name="employee_slug" id="non-existing-employee-select" cols="12" :options="[]"/>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Payroll Group" name="payroll_group" cols="12" :options="\App\Swep\Helpers\Arrays::payrollGroups()"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

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

    <x-adminkit.html.modal-template id="update-row-modal" size="sm" form-id="update-row-form">
        <x-slot:title>
            Update all values in selected row
        </x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Value" name="value" cols="12" type="text" />
            <x-forms.input label="Element" name="element" cols="12" type="text" container-class="hide-this"/>
        </div>
        <div class="row mb-2 hide-this">
            <x-forms.checkbox label="Include Non-empty fields" type="checkbox" name="include_non_empty" cols="12" :options="['1' => 'Include']" :value="null"/>

        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Set</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

    <x-adminkit.html.offcanvas class="end asdasd" id="offcanvasLeft">
        <x-slot:title>
            Employee Options
        </x-slot:title>
    </x-adminkit.html.offcanvas>

    <x-adminkit.html.offcanvas class="end" id="print-offcanvas">
        <x-slot:title>
            Print Options
        </x-slot:title>
        <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'DIFF-YEB'])}}" target="_blank" class="btn btn-outline-primary btn-sm col-12 mb-2 require-dialog"> <i class="fa fa-print"></i> Payroll Summary</a>
        <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'DIFF-DEDUCTION-REGISTER'])}}" target="_blank" class="btn btn-outline-primary btn-sm col-12 mb-2 require-dialog"> <i class="fa fa-print"></i> Deduction Register</a>
        <a href="{{route('dashboard.payroll_preparation.print',[$payrollMaster->slug,'GLOBAL-ABSTRACT'])}}" target="_blank" class="btn btn-outline-primary btn-sm col-12 mb-2 require-dialog"> <i class="fa fa-print"></i> Abstract</a>

    </x-adminkit.html.offcanvas>
@endsection

@section('scripts')
    <script type="text/javascript">
        const daysInMonth = {!! json_encode($daysInMonthArray) !!};
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

        $("body").on("click",".edit-deduction",function(){
            let btn = $(this);
            let employeeListSlug = btn.parent('tr').attr('data');
            let slug = btn.attr('data');
            let deductionCode = btn.attr('deduction-code');
            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?editDeduction';
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
                    window.open(link+'?'+$("#"+newId).serialize(), target);
                }
            });
        });

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
                    // recompute($("#recompute_btn"));
                    toast('info','Excel data successfully imported','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("#add-employee-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            var formData = new FormData(this);
            let uri = '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?addEmployee=true';
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


        $("body").on("click",".delete-clone-btn",function (){
            let uri = '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?clone=true';
            let btn = $(this);
            let tr = btn.parents('tr');
            let type = btn.attr('for')
            let data = {
                data : btn.attr('data'),
                type : type,
            }
            $.ajax({
                url : uri,
                data: data,
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    if(type === 'clone'){
                        $('<tr class="animate__animated animate__flash" data="'+res.slug+'" data-emp="'+res.employee_slug+'">'+res.view+'</tr>').insertAfter(tr);
                        $($("tr[data='"+res.slug+"']").find(".autonum-simple")).each(function(){
                            new AutoNumeric(this, autonum_settings_simple);
                        });
                    }
                    if(type === 'delete'){
                        $("tr[data='"+res+"']").remove();
                    }


                },
                error: function (res) {

                }
            })
        })


        $("body").on("click",".remove-column-btn",function (){
            let btn = $(this);
            Swal.fire({
                title: "Are you sure you want to remove "+ btn.attr('code')+ " column?",
                showCancelButton: true,
                confirmButtonText: "REMOVE COLUMN",
                confirmButtonColor : '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?removeColumn',
                        data : {
                            code : btn.attr('code'),
                        },
                        type: 'POST',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            toast('info','Column successfully removed.','Success!');
                            $("#recompute-btn").trigger("click");
                        },
                        error: function (res) {

                        }
                    })
                }
            });
        })

        $("#diff-form").submit(function (e){
            e.preventDefault();
            let uri = '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?recompute=true';
            let tbl = $("#payroll-employees-table");
            tbl.find('.animate__flash').each(function (){
                $(this).removeClass('animate__flash');
            })
            let data = $(this).serializeArray();
            let focusedInput = $('input:focus');
            let focusedInputTr = focusedInput.parents('tr');
            focusedInputTr.find('input').each(function (){
                $(this).attr('disabled','disabled');
            });

            $.ajax({
                url : uri,
                type: 'POST',
                data: data,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    let count;
                    if (Array.isArray(res)) {
                        count = res.length;           // JSON array
                    } else {
                        count = Object.keys(res).length; // JSON object
                    }
                    if(count > 0){
                        $.each(res,function (index,value){
                            let row = tbl.find('tr[data="'+index+'"]');
                            row.addClass('animate__flash');
                            row.html(value);

                            $(row.find(".autonum-simple")).each(function(){
                                new AutoNumeric(this, autonum_settings_simple);
                            });
                        })
                    }
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        $('body').on('change','.date-change',function (){
            let parentTr = $(this).parents('tr');
            let from = parentTr.find('input[for="diff_from"]').val().split('-')[2];
            let to = parentTr.find('input[for="diff_to"]').val().split('-')[2];
            let workingDays = 0;
            if(typeof from !== "undefined" && typeof to !== "undefined"){
                from = parseInt(from);
                to = parseInt(to);
                for (let i = from; i <= to; i++ ){
                    if(daysInMonth[i]){
                        workingDays++;
                    }
                }
            }
            if(workingDays > 22){
                workingDays = 22;
            }
            parentTr.find('input[for="diff_days"]').val(workingDays);
            // console.log(workingDays);
        })

        $("body").on("click",".update-row-btn",function (){
            let btn = $(this);
            let data =  JSON.parse(btn.attr('data'));
            let form = $("#update-row-form");
            let input = form.find('input[name="value"]');
            let min = '{{Carbon::parse($payrollMaster->date)->firstOfMonth()->format('Y-m-d')}}';
            let max = '{{Carbon::parse($payrollMaster->date)->lastOfMonth()->format('Y-m-d')}}';
            input.attr('type',data['type']);
            if(data['type'] === 'date'){
                input.attr('min',min);
                input.attr('max',max);
            }else{
                input.removeAttr('min');
                input.removeAttr('max');
            }
            form.find('input[name="element"]').val(data.element);
        })

        $("#update-row-form").submit(function (e){
            e.preventDefault();
            let data = $(this).serializeArray();
            let element = data.find(item => item.name === "element").value;
            let value = data.find(item => item.name === "value").value;
            let elementsToUpdate = $("#payroll-employees-table").find('input[for="'+element+'"]');
            elementsToUpdate.each(function (){
                $(this).val(value).trigger('change');
            })
        })
        $("body").on('change','.detect-change',function (){
            let t = $(this);
            let tr = t.parents('tr');
            tr.find("input[for='has_been_changed']").val(1);
        })

        $(".fetch-mbs-btn").click(function (){
            let btn = $(this);
            let type = $(this).attr('data');
            wait_this_button(btn, 'Fetch');

            let uri = '{{route("dashboard.payroll_preparation.edit",$payrollMaster->slug)}}?fetchMbs&type='+type;
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $.each(res,function (employeeSlug,oldMbs){

                        if(oldMbs !== null){
                            $("tr[data='"+employeeSlug+"']").each(function (){
                                let slug = $(this).attr('data');
                                AutoNumeric.getAutoNumericElement('#an-'+type+'-mbs-'+slug).set(oldMbs);
                            })
                        }
                    });
                    toast('info','Fetch successful.','');
                    unwait_this_button(btn);
                },
                error: function (res) {
                    unwait_this_button(btn);
                }
            })
        })
        console.log({!! $nonExistingEmployees->toJson() !!});

        $("#non-existing-employee-select").select2({
            data : {!! $nonExistingEmployees->toJson() !!},
            dropdownParent : $("#add-employee-modal"),
        })

    </script>

@endsection