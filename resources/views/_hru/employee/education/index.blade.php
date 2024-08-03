@extends('adminkit.master')
@php
    /** @var \App\Models\Employee $employee **/
@endphp
@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi'] ?? ''}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position }}</x-slot:subtitle>
        <x-slot:float-end>Credentials</x-slot:float-end>
    </x-adminkit.html.page-title>
    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Education</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Eligibilities</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Work Experience</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active show" id="tab-1" role="tabpanel">

               <div class="row mb-2">
                   <div class="col-md-12 " >
                       <div class="btn-group float-end">
                           <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-education-modal"><i class="fas fa-plus"></i> Add Education</button>
                       </div>
                   </div>
               </div>
                <div id="education-table-container" class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm" id="education-table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Level</th>
                            <th >School Name</th>
                            <th >Course</th>
                            <th >From</th>
                            <th >To</th>
                            <th >Units</th>
                            <th >Graduated</th>
                            <th >Scholarship.</th>
                            <th >Honor</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab-2" role="tabpanel">
                <div class="row mb-2">
                    <div class="col-md-12 " >
                        <div class="btn-group float-end">
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-eligibility-modal"><i class="fas fa-plus"></i> Add Eligibility</button>
                        </div>
                    </div>
                </div>

                <div id="eligibility-table-container" class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm" id="eligibility-table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Eligibility</th>
                            <th >Level</th>
                            <th >Rating</th>
                            <th >Exam Place</th>
                            <th >Exam Date</th>
                            <th >License No.</th>
                            <th >Validity</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab-3" role="tabpanel">
                <div class="row mb-2">
                    <div class="col-md-12 " >
                        <div class="btn-group float-end">
                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-work-modal"><i class="fas fa-plus"></i> Add Work Experience</button>
                        </div>
                    </div>
                </div>

                <div id="work-table-container" class="table-responsive">
                    <table class="align-top table table-bordered table-striped table-hover table-sm" id="work-table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Company</th>
                            <th >Position</th>
                            <th >From</th>
                            <th >To</th>
                            <th >Salary</th>
                            <th >SG</th>
                            <th >Step</th>
                            <th >Appt. Status</th>
                            <th >Gov't Service</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-education-modal" form-id="add-education-form">
        <x-slot:title>Add Education</x-slot:title>
        <div class="row mb-2">
            <x-forms.select label="Level" name="level" cols="4" :options="\App\Swep\Helpers\Helper::educationalLevels()" />
            <x-forms.input label="School" name="school_name" cols="8"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Course" name="course" cols="6"/>
            <x-forms.input label="Date from" name="date_from" cols="3"/>
            <x-forms.input label="Date to" name="date_to" cols="3"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Units" name="units" cols="2"/>
            <x-forms.input label="Year Graduated" name="graduate_year" cols="3"/>
            <x-forms.input label="Scholarship" name="scholarship" cols="7"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Honor" name="honor" cols="6"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>

    <x-adminkit.html.modal id="edit-education-modal"/>

    <x-adminkit.html.modal-template id="add-eligibility-modal" form-id="add-eligibility-form">
        <x-slot:title>Add Eligibility</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Eligibility" name="eligibility" cols="8"/>
            <x-forms.input label="Level" name="level" cols="4"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Rating" name="rating" cols="3" step="0.01" type="number"/>
            <x-forms.input label="Place of exam" name="exam_place" cols="5"/>
            <x-forms.input label="Date of exam" name="exam_date" cols="4" type="date"/>

        </div>
        <div class="row mb-2">
            <x-forms.input label="License No." name="license_no" cols="4"/>
            <x-forms.input label="License Validity" name="license_validity" cols="4" type="date"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-eligibility-modal"/>


    <x-adminkit.html.modal-template id="add-work-modal" form-id="add-work-form">
        <x-slot:title>Add Work Experience</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Company" name="company" cols="7"/>
            <x-forms.input label="Position" name="position" cols="5"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Date from" name="date_from" cols="4" type="date"/>
            <x-forms.input label="Date to" name="date_to" cols="4" type="date"/>
        </div>
        <hr class="no-margin">
        <div class="row mb-2">
            <x-forms.input label="Salary" name="salary" cols="4"/>
            <x-forms.input label="SG" name="salary_grade" cols="4"/>
            <x-forms.input label="Step" name="step" cols="4"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Appointment Status" name="appointment_status" cols="4"/>
            <x-forms.select label="Gov't Service" name="is_gov_service" cols="4" :options="[0 => 'NO', 1 => 'YES']"/>
        </div>

        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-work-modal"/>

@endsection

@section('scripts')
<script type="text/javascript">
    //EDUCATION
    educationActive = '';
    educationTbl = $("#education-table").DataTable({
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "ajax" : '{{route('dashboard.employee.education',$employee->slug)}}',
        "columns": [
            { "data": "level" },
            { "data": "school_name" },
            { "data": "course" },
            { "data": "date_from" },
            { "data": "date_to" },
            { "data": "units" },
            { "data": "graduate_year" },
            { "data": "scholarship" },
            { "data": "honor" },
            { "data": "action"}
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : 9,
                "orderable" : false,
                "searchable": false,
                "class" : 'action-6p'
            },
        ],
        "responsive": true,
        "initComplete": function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    educationTbl.search(this.value).draw();
                }
            });
        },
        "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(educationActive != ''){
                $("#"+settings.sTableId+" #"+educationActive).addClass('table-success');
            }
        }
    })
    $("#add-education-form").submit(function (e) {
        e.preventDefault();
        let uri = '{{route("dashboard.employee.education",$employee->slug)}}';
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
                educationActive = res.slug;
                educationTbl.draw(false);
                succeed(form,true,false);
                toast('success','Data successfully saved.','Success!');
            },
            error: function (res) {
                errored(form,res)
            }
        })
    })
    $("body").on("click",".edit-education-btn",function () {
        let btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.employee.education","slug")}}?edit';
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
    //EDUCATION END


    //ELIGIBILITY
    eligibilityActive = '';
    eligibilityTbl = $("#eligibility-table").DataTable({
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "ajax" : '{{route('dashboard.employee.eligibility',$employee->slug)}}',
        "columns": [
            { "data": "eligibility" },
            { "data": "level" },
            { "data": "rating" },
            { "data": "exam_place" },
            { "data": "exam_date" },
            { "data": "license_no" },
            { "data": "license_validity" },
            { "data": "action"}
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : 7,
                "orderable" : false,
                "searchable": false,
                "class" : 'action-6p'
            },
        ],
        "responsive": true,
        "initComplete": function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    eligibilityTbl.search(this.value).draw();
                }
            });
        },
        "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(eligibilityActive != ''){
                $("#"+settings.sTableId+" #"+eligibilityActive).addClass('table-success');
            }
        }
    })
    $("#add-eligibility-form").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let uri = '{{route("dashboard.employee.eligibility",$employee->slug)}}';
        loading_btn(form);
        $.ajax({
            url : uri,
            data : form.serialize(),
            type: 'POST',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                eligibilityActive = res.slug;
                eligibilityTbl.draw(false);
                succeed(form,true,false);
                toast('success','Data successfully saved.','Success!');
            },
            error: function (res) {
                errored(form,res)
            }
        })
    })
    $("body").on("click",".edit-eligibility-btn",function () {
        let btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.employee.eligibility","slug")}}?edit';
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
    //ELIGIBILITY END

    //WORK
    workActive = '';
    workTbl = $("#work-table").DataTable({
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "ajax" : '{{route('dashboard.employee.work',$employee->slug)}}',
        "columns": [
            { "data": "company" },
            { "data": "position" },
            { "data": "date_from" },
            { "data": "date_to" },
            { "data": "salary" },
            { "data": "salary_grade" },
            { "data": "step" },
            { "data": "appointment_status" },
            { "data": "is_gov_service" },
            { "data": "action"}
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "order": [[0,'asc']],
        "columnDefs":[
            {
                "targets" : 4,
                "class" : 'text-end'
            },
            {
                "targets" : 9,
                "orderable" : false,
                "searchable": false,
                "class" : 'action2'
            },
        ],
        "responsive": true,
        "initComplete": function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    workTbl.search(this.value).draw();
                }
            });
        },
        "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(workActive != ''){
                $("#"+settings.sTableId+" #"+workActive).addClass('table-success');
            }
        }
    })
    $("#add-work-form").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let uri = '{{route("dashboard.employee.work",$employee->slug)}}';
        loading_btn(form);
        $.ajax({
            url : uri,
            data : form.serialize(),
            type: 'POST',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                workActive = res.slug;
                workTbl.draw(false);
                succeed(form,true,false);
                toast('success','Data successfully saved.','Success!');
            },
            error: function (res) {
                errored(form,res)
            }
        })
    })
    $("body").on("click",".edit-work-btn",function () {
        let btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.employee.work","slug")}}?edit';
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
    //WORK END


</script>
@endsection