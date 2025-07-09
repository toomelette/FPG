@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Time Keeping Form</x-slot:title>
        <x-slot:subtitle>Create</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <form id="time-keeping-form">
        <x-adminkit.html.card header-class="pb-1 pt-3">
            <x-slot:title>
                <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>

            <div class="row">
                <div class="col-md-3">
                    <x-adminkit.html.alert type="success mb-2" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        Employee Details
                    </x-adminkit.html.alert>
                    <p class="text-muted no-margin">Employee Name:</p>
                    <h5>{{Auth::user()->employee->full['FMiLE']}}</h5>

                    <p class="text-muted no-margin">Position:</p>
                    <h5>{{Auth::user()->employee->plantilla->position ?? Auth::user()->employee->position}}</h5>

                    <p class="text-muted no-margin">Department - Division - Section:</p>
                    <h5>{{Auth::user()->employee->responsibilityCenter?->desc ?? '-'}}</h5>
                </div>
                <div class="col-md-6">
                    <x-adminkit.html.alert type="success mb-2" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        Time Keeping Form Details
                    </x-adminkit.html.alert>
                    <div class="row mb-2">
                        <x-forms.input label="Month" name="month" cols="3" type="month" id="select-month"/>
                    </div>
                    <table class="table table-sm table-bordered" id="time-keeping-dates-table">
                        <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center" style="width: 150px;">AM IN</th>
                            <th class="text-center" style="width: 150px;">AM OUT</th>
                            <th class="text-center" style="width: 150px;">PM IN</th>
                            <th class="text-center" style="width: 150px;">PM OUT</th>
                            <th style="width: 40px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-info" id="table-placeholder"><i class="fa fa-info-circle"></i> Select a month first</td>
                        </tr>

                        </tbody>
                        <tfoot style="display: none">
                        <tr>
                            <td colspan="6" class="text-center">
                                <a href="#" id="add-date" class="text-strong"><i class="fa fa-plus"></i>Add date</a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-3">
                    <x-adminkit.html.alert type="success mb-2" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        DTR Logs
                    </x-adminkit.html.alert>
                    <div id="dtr-logs" style="font-size: 12px">

                    </div>
                </div>
            </div>

        </x-adminkit.html.card>
    </form>
    <table style="display:none;">
        <tbody id="time-keeping-row-template">
        <tr>
            <td style="vertical-align: top">
                <x-forms.select :select-only="true" label="Date" name="dates[slug][day]" cols="12" class="select-day" :auto-class="true"/>
            </td>
            <td style="vertical-align: top">
                <x-forms.input :input-only="true" label="Am In" name="dates[slug][am_in]" cols="12" type="time" :auto-class="true"/>
            </td>
            <td style="vertical-align: top">
                <x-forms.input :input-only="true" label="Am In" name="dates[slug][am_out]" cols="12" type="time" :auto-class="true"/>
            </td>
            <td style="vertical-align: top">
                <x-forms.input :input-only="true" label="Am In" name="dates[slug][pm_in]" cols="12" type="time" :auto-class="true"/>
            </td>
            <td style="vertical-align: top">
                <x-forms.input :input-only="true" label="Am In" name="dates[slug][pm_out]" cols="12" type="time" :auto-class="true"/>
            </td>
            <td style="vertical-align: top">
                <button type="button" class="btn btn-sm btn-danger remove_row_btn" ><i class="fa fa-times"></i></button>
            </td>
        </tr>
        </tbody>
    </table>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        var daysInSelectedMonth = 0;
        function daysInTheMonth(month) {
            var now = new Date(month);
            var newDays =  new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
            daysInSelectedMonth = newDays;
            return newDays;
        }

        function getDTR(month){
            $.ajax({
                url : '{{route("dashboard.time_keeping.create")}}',
                data : {
                    getDtr : true,
                    month : month,
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#dtr-logs").html(res);
                },
                error: function (res) {

                }
            })
        }


        $("#select-month").change(function (){
            let selectedMonth = $(this).val();
            let totalDays = daysInTheMonth(selectedMonth+'-01');
            let tablePlaceholder = $("#time-keeping-dates-table #table-placeholder")
            $(".select-day").each(function (){
                $(this).html('<option value="">Select</option>');
                for (i = 0; i < daysInSelectedMonth; i++){
                    let date = i+1;
                    $(this).append('<option value="'+date+'">'+date+'</option>')
                }
            });
            if(tablePlaceholder.css('display') !== 'none'){
                $("#add-date").click();
            }
            tablePlaceholder.hide();
            $("#time-keeping-dates-table tfoot").show();
            getDTR(selectedMonth);
        })

        $("#add-date").click(function (e){
            e.preventDefault();
            let id = makeId(10);
            rowTemplate = $("#time-keeping-row-template").html();
            rowTemplate = rowTemplate.replaceAll('slug',id);
            $("#time-keeping-dates-table tbody").append(rowTemplate);
        })

        $("#time-keeping-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.time_keeping.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection