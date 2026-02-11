@extends('adminkit.master')

@section('content')

@endsection
@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi']}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position}} ({{$employee?->plantilla?->item_no}})</x-slot:subtitle>
        <x-slot:float-end>Service Records</x-slot:float-end>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card>
        <x-slot:title>
            <div class="btn-group float-end">
                <button class="btn btn-sm btn-outline-secondary " type="button" data-bs-toggle="modal" data-bs-target="#print-service-record-modal"><i class="fas fa-print"></i> Print</button>
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-service-record-modal"><i class="fas fa-plus"></i> Add Service Record</button>
            </div>
        </x-slot:title>

        <div id="service_records_table_container">
            <table class="table table-bordered table-striped table-hover table-sm" id="service_records_table" style="width: 100% !important">
                <thead>
                <tr class="">
                    <th >Seq #</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Position</th>
                    <th>Appt. Status</th>
                    <th>Monthly Basic</th>
                    <th>Annual Salary</th>
                    <th style="width: 180px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-sr-modal" size="60"/>

    <x-adminkit.html.modal-template id="add-service-record-modal" form-id="add-sr-form">
        <x-slot:title>
            Add Service Record
        </x-slot:title>

        <div class="row">
            <x-forms.input label="Seq. #" name="sequence_no" cols="4" />
            <x-forms.input label="Date From" name="from_date" cols="4" type="date"/>
            <div class="form-group col-md-4 to_date ">
                <label for="to_date">Date To *</label>
                <input class="form-control " id="to_date" name="to_date" type="date" value="" placeholder="Date To">
                <div class="checkbox no-margin">
                    <label>
                        <input type="checkbox" name="upto_date"> Upto present
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Item No. (If applicable)" name="item_no" id="item_no" cols="12" :options="[]"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Position Title" name="position" cols="8" />
            <x-forms.select label="Appointment Status" name="appointment_status" cols="4" :options="\App\Swep\Helpers\Arrays::appointmentStatus()"/>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Salary Type" name="salary_type" cols="4" :options="\App\Swep\Helpers\Arrays::salaryTypes()"/>
            <x-forms.input label="SG/JG/PG" name="grade" cols="4" type="number"/>
            <x-forms.select label="Step" name="step" cols="4" :options="\App\Swep\Helpers\Arrays::stepIncements()"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Monthly Basic Salary" name="monthly_basic" cols="6" target="#annual_salary"  class="targeted-autonum monthly_basic" />
            <x-forms.select label="Due to" name="due_to" cols="6" :options="\App\Swep\Helpers\Arrays::serviceRecordDueTo()"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Salary (Annual)" name="salary" cols="6" id="annual_salary" class="targeted-autonum" />
            <x-forms.input label="Mode of Payment" name="mode_of_payment" cols="6" />
        </div>
        <div class="row mb-2">
            <x-forms.input label="Station" name="station" cols="4" />
            <x-forms.select label="Government Serve" name="gov_serve" cols="4" :options="['YES' => 'YES', 'NO' => 'NO' ]"/>
            <x-forms.input label="PSC Serve" name="psc_serve" cols="4" />
        </div>
        <div class="row mb-2">
            <x-forms.input label="LWP" name="lwp" cols="4" />
            <x-forms.input label="SP Date" name="spdate" cols="4" />
            <x-forms.input label="Status" name="status" cols="4" />
        </div>
        <div class="row">
            <x-forms.input label="Remarks" name="remarks" cols="12" />
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>


    <x-adminkit.html.modal-template id="print-service-record-modal" form-id="print-sr-form" form-target="_blank" form-method="GET" :form-action="route('dashboard.employee.service_record',$employee->slug)" form-data="formdata">
        <x-slot:title>
            Add Service Record
        </x-slot:title>
        <div class="row mb-2">
            <input name="print" value="true" hidden>
            <x-forms.input label="Prepared by" name="pn" cols="6" />
            <x-forms.input label="Position" name="pp" cols="6"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Certified by" name="cn" cols="6" />
            <x-forms.input label="Position" name="cp" cols="6"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Approved by" name="an" cols="6" />
            <x-forms.input label="Position" name="ap" cols="6"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Items per page:" name="no_of_items" :value="35" cols="6" type="number"/>
            <x-forms.select label="Sorting" name="sort_by" value="asc" :options="['asc'=>'Ascending','desc' => 'Descending']" cols="3" />
            <x-forms.select label="Gov Serv." name="gov_serve" value="YES" :options="['YES' => 'YES', 'NO' => 'NO' ]" cols="3" />
        </div>

        <x-slot:footer>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Print</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

@endsection
@php
    $plantillas = \App\Models\HRPayPlanitilla::query()
        ->with(['responsibilityCenter'])
        ->get()
        ->map(function ($plantilla){
            return [
                'id' => $plantilla->item_no,
                'text' => $plantilla->item_no .' - '.$plantilla->position .' --- ('.$plantilla?->responsibilityCenter?->desc.')',
                'position' => $plantilla->position,
                'JG' => $plantilla->original_job_grade,
                'SG' => $plantilla->original_salary_grade,
                'PG' => $plantilla->original_salary_grade,
                'resp_center' => $plantilla?->responsibilityCenter?->desc
            ];
        });
@endphp
@section('scripts')
    <script type="text/javascript">
        sr_active = '';
        uri = "{{route('dashboard.employee.service_record',$employee->slug)}}";
        service_records_tbl = $("#service_records_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : uri,
            "type" : 'GET',
            "columns": [
                { "data": "sequence_no" },
                { "data": "from_date" },
                { "data": "to_date" },
                { "data": "position" },
                { "data": "appointment_status" },
                { "data": "monthly_basic" },
                { "data": "salary" },
                { "data": "action" }
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 5,
                    "class" : 'text-end',
                },
                {
                    "targets" : 6,
                    "class" : 'text-end'
                },
                {
                    "targets" : 7,
                    "orderable" : false,
                },
            ],
            "order":[[0,'desc']],
            "responsive": false,
            "initComplete": function( settings, json ) {
                $('#tbl_loader_2').fadeOut(function(){
                    $("#service_records_table_container").fadeIn();
                });
            },
            "drawCallback": function(settings){
                if(sr_active != ''){
                    $("#service_records_table #"+sr_active).addClass('table-success');
                }
            }
        })
        style_datatable("#service_records_table");
        //Need to press enter to search
        $('#service_records_table_filter input').unbind();
        $('#service_records_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                service_records_tbl.search(this.value).draw();
            }
        });

        $("#add-sr-form").submit(function (e) {
            e.preventDefault();
            uri = '{{route('dashboard.employee.service_record',$employee->slug)}}';
            uri = uri.replace('slug','{{$employee->slug}}');
            var form = $(this);
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    sr_active = res.slug;
                    service_records_tbl.draw(false);
                    toast("success","Data successfully saved.","Success");
                    $("input[name='to_date']").removeAttr('disabled');
                    wipe_autonum();
                },
                error: function (res) {
                    errored(form,res)
                    console.log(res);
                }
            })
        })

        $('body').on('change',"input[name='upto_date']",function (){
            let t = $(this);
            if(t.prop('checked')){
                t.parents('.to_date').find('input[name="to_date"]').attr('disabled','disabled');
            }else{
                t.parents('.to_date').find('input[name="to_date"]').removeAttr('disabled');
            }
        })

        $("body").on("click",".edit-sr-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.employee.service_record","slug")}}?edit=true';
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

        let plantillas = {!! $plantillas->toJson() !!}
        $("#item_no").select2({
            data: plantillas,
            dropdownParent: $("#add-service-record-modal")
        });
        $('#item_no').on('select2:select', function (e) {
            let data = e.params.data;
            let form = $(this).parents('form');
            form.find('input[name="position"]').val(data.position);
            form.find('input[name="grade"]').val(data.JG);
        });
        $("body").on("change keyup",".monthly_basic",function (){
            let monthlySalary = sanitizeAutonum($(this).val());
            let annualSalary = monthlySalary * 12;
            if(annualSalary != 0){
                AutoNumeric.getAutoNumericElement($(this).attr('target')).set(annualSalary);
            }
        })


    </script>
@endsection