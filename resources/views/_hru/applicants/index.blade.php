@extends('adminkit.master')


@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Applicants</x-slot:title>

    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" id="intro" data-intro='Click here.' data-bs-target="#add-applicant-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>
        <x-adminkit.html.accordion id="filter-accordion" class="accordion-sm mb-3" state="0">
            <x-slot:title>
                <i class="fas fa fa-filter"></i> Advanced Filters
            </x-slot:title>
            <form id="filter_form">
                <div class="row mb-2">
                    <x-forms.select label="Course" cols="4" container-class="dt_filter-parent-div" name="course" class="dt_filter filters select2_course_filter" :options="[]"/>
                    <x-forms.select label="Sex" cols="2" container-class="dt_filter-parent-div" name="sex" class="dt_filter" :options="['MALE' => 'MALE','FEMALE' => 'FEMALE']"/>
                    <x-forms.select label="Civil Status" cols="2" container-class="dt_filter-parent-div" name="civil_status" class="dt_filter" :options="\App\Swep\Helpers\Arrays::civil_status()"/>
                    <x-forms.select label="Position applied for" cols="4" container-class="dt_filter-parent-div" name="position_applied" class="dt_filter select2_position_applied_filter" :options="[]"/>
                </div>
                <div class="row">
                    <x-forms.select label="Item No" cols="4" container-class="dt_filter-parent-div" name="item_no" class="dt_filter select2_item_no_filter" :options="[]"/>
                </div>
            </form>
        </x-adminkit.html.accordion>
        <table class="table table-bordered table-striped table-hover table-sm" id="applicants-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th >Name</th>
                <th>Position(s) Applied</th>
                <th >Course</th>
                <th >Age</th>
                <th ><small>Appln. Date</small></th>
                <th >SL</th>
                <th style="width: 80px;">Action</th>
                <th>Updated at</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-applicant-modal" size="lg"/>
    <x-adminkit.html.modal-template id="add-applicant-modal" size="lg" form-id="add-applicant-form">
        <x-slot:title>Add Applicant</x-slot:title>

        <div class="row mb-2">
            <x-forms.input label="Date received:" name="received_at" cols="3" type="date"/>
            <x-forms.input label="Last Name:" name="lastname" cols="3"/>
            <x-forms.input label="First Name:" name="firstname" cols="3"/>
            <x-forms.input label="Middle Name:" name="middlename" cols="3"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Birthday:" name="date_of_birth" cols="2" type="date"/>
            <x-forms.select label="Sex:" name="gender" cols="2" :options="\App\Swep\Helpers\Arrays::sex()"/>
            <x-forms.select label="Civil Status:" name="civil_status" cols="2" :options="\App\Swep\Helpers\Arrays::civil_status()"/>
            <x-forms.input label="Address:" name="address" cols="6" />
        </div>

        <div class="row mb-2">
            <x-forms.select label="Course:" name="course" class="select2_course" cols="6"/>
            <x-forms.input label="School:" name="school" cols="6" />

        </div>

        <div class="row mb-2">
            <div class="form-group col-md-12 position_applied">
                <label for="school">Position(s) Applied for:</label>
                <br>
                <input value="{{old('position_applied')}}" type="text" name="position_applied" id="position_applied" class="form-control" value="" data-role="tagsinput" style="width:100%;">
                <p class="text-info"><i class="fa fa-info"></i> You can add more "Position applied for" by pressing <b>ENTER</b>. </p>
            </div>
        </div>

        <div class="row">
            <x-forms.input label="Contact No:" name="contact_no" cols="6"/>
        </div>

        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('template/plugins/bloodhound/typeahead.js') }}"></script>

    <script type="text/javascript">

        $(".dt_filter").change(function () {
            filterDT(applicantsTbl);
        })

        $(".select2_course").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_courses")}}?default=Select',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $('#add-applicant-modal')
        });
        $(".select2_course_filter").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_courses")}}?default=DontFilter',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $('.card')
        });
        $(".select2_position_applied_filter").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_filter_position")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $('.card')
        })
        $(".select2_item_no_filter").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_filter_item_no")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $('.card')
        })
        var citynames = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '{{route("dashboard.ajax.get","position_applied")}}?rand={{\Illuminate\Support\Str::random()}}',
                filter: function(list) {
                    return $.map(list, function(cityname) {
                        return { name: cityname }; });
                }
            }
        });
        citynames.initialize();
        $("#position_applied").tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: citynames.ttAdapter(),
            }
        });


        let active = '';
        applicantsTbl = $("#applicants-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{route('dashboard.applicant.index')}}',
            columns : [
                { data : "fullname" },
                { data : "position_applied" },
                { data : "course" },
                { data : "date_of_birth" },
                { data : "received_at" },
                { data : "sl" },
                { data : "action" },
                { data : "updated_at" },
            ],
            buttons : [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs :[
                {
                    targets: '_all',
                    class : 'align-top'
                },
                {
                    targets : 0,
                    class : 'w-20p'
                },
                {
                    targets : 2,
                    class : 'w-25p'
                },
                {
                    targets : 1,
                    class : 'w-15p'
                },
                {
                    targets : [3,4],
                    class : 'text-center',
                },
                {
                    targets : 6,
                    orderable : false,
                    class : ''
                },
                {
                    targets : 7,
                    visible : false,
                },
            ],
            order:[[0,'asc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        applicantsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $('.bootstrap-tagsinput input').on('keypress', function(e){
            if (e.keyCode == 13){
                e.keyCode = 188;
                e.preventDefault();
            };
        });
        $("#add-applicant-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.applicant.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    $(".course .select2-selection__rendered").html('Select');
                    $("#position_applied").tagsinput('removeAll');
                    toast('success','Applicant successfully added.','Success');
                    active = res.slug;
                    applicants_tbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on('click','.edit-applicant-btn',function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.applicant.edit","slug")}}';
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