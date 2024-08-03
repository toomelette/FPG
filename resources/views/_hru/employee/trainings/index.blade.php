@extends('adminkit.master')
@php
    /** @var \App\Models\Employee $employee**/
@endphp

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi']}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position}}</x-slot:subtitle>
        <x-slot:float-end>Trainings</x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title>
            <div class="btn-group float-end">
                <button class="btn btn-sm btn-outline-secondary " type="button" data-bs-toggle="modal" data-bs-target="#print-trainings-modal"><i class="fas fa-print"></i> Print</button>
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-trainings-modal"><i class="fas fa-plus"></i> Add Training</button>
            </div>
        </x-slot:title>
        <div id="trainings_table_container" >
            <table class="table table-bordered table-striped table-hover training table-sm" id="trainings_table" style="width: 100% !important">
                <thead>
                <tr class="">
                    <th>Seq #</th>
                    <th>Title</th>
                    <th>Started</th>
                    <th>Ended</th>
                    <th>Detailed Period</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-trainings-modal" form-id="add-training-form">
        <x-slot:title>Add Training</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Sequence No." name="sequence_no" cols="6" type="number" />
            <x-forms.input label="Type of Seminar." name="type" cols="6" />
        </div>

        <div class="row mb-2">
            <x-forms.input label="Title" name="title" cols="12" />
        </div>

        <div class="row mb-2">
            <x-forms.input label="Started" name="date_from" cols="6" type="date"/>
            <x-forms.input label="Ended" name="date_to" cols="6" type="date"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Detailed Period:" name="detailed_period" cols="12" placeholder="E.g.: Feb 1,3,4,7 2015"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Hours" name="hours" cols="6" type="number"/>
            <x-forms.input label="Conducted By" name="conducted_by" cols="6"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Venue" name="venue" cols="6"/>
            <x-forms.input label="Remarks" name="remarks " cols="6"/>
            <x-forms.select label="Is Relevant" name="is_relevant " cols="6" :options="['1' => 'YES', '0' => 'NO']"/>
        </div>

        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

    <x-adminkit.html.modal-template id="print-trainings-modal" form-id="print-training-form" form-target="_blank" form-moethod="GET" :form-action="route('dashboard.employee.training',$employee->slug)">
        <x-slot:title>Print Trainings</x-slot:title>
        <div class="row mb-2">
            <input name="print" value="true" hidden/>
            <x-forms.input label="Date from" name="df" cols="6" type="date"/>
            <x-forms.input label="Date to" name="dt" cols="6" type="date"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Items per sheet" name="items_per_sheet" cols="3" type="number" :value="20"/>
        </div>

        <x-slot:footer>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Print</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

    <x-adminkit.html.modal id="edit-training-modal"/>
@endsection

@section('scripts')
<script type="text/javascript">
    active = '';
    trainings_tbl = $("#trainings_table").DataTable({
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "ajax" : '{{route('dashboard.employee.training',$employee->slug)}}',
        "columns": [
            { "data": "sequence_no" },
            { "data": "title" },
            { "data": "date_from" },
            { "data": "date_to" },
            { "data": "detailed_period" },
            { "data": "action" }
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : 0,
                "class" : 'w-6p'
            },
            {
                "targets" : 1,
                "class" : 'w-50p'
            },
            {
                "targets" : [2,3],
                "class" : 'w-8p'
            },
            {
                "targets" : 4,
                "class" : 'w-20p'
            },
            {
                "targets" : 5,
                "orderable" : false,
                "class" : 'action-8p'
            },
        ],
        "order":[[0,'desc']],
        "responsive": false,
        "initComplete": function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    trainings_tbl.search(this.value).draw();
                }
            });
        },
        "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(active != ''){
                $("#"+settings.sTableId+" #"+active).addClass('table-success');
            }
        }
    })

    $("#add-training-form").submit(function (e){
        e.preventDefault();
        uri = '{{route('dashboard.employee.training',$employee->slug)}}';
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
                trainings_active = res.slug;
                trainings_tbl.draw(false);
                notify("Data successfully saved.","success");
            },
            error: function (res) {
                errored(form,res)
                console.log(res);
            }
        })
    })

    $("body").on("click",".edit-training-btn",function (){
        btn = $(this);
        load_modal2(btn);
        var uri = "{{route('dashboard.employee.training','slug')}}?edit";
        uri  = uri.replace("slug",btn.attr('data'));
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
                toast("error",res.responseJSON.message,"Error:");
                console.log(res);
            }
        })
    })

</script>
@endsection