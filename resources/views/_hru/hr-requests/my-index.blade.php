@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Request for Certifications and Other HR Documents</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div id="requests-table-container" class="table-responsive">
            <table class="table table-bordered table-sm" id="requests-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th>Date of Request</th>
                    <th>Requested Document</th>
                    <th>Tracking No.</th>
                    <th>Staus</th>
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
    <x-adminkit.html.modal id="show-timeline-modal" />
    <x-adminkit.html.modal-template id="download-cos-modal" form-id="download-cos-form" form-target="_blank">
        <x-slot:title>Download Contract of Service</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Address" name="address" cols="8" required="required"/>
            <x-forms.select label="Civil Status" name="civil_status" cols="4" :options="\App\Swep\Helpers\Arrays::civil_status()" required="required"/>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Witness" name="witness_1" cols="6" class="select-employee" required="required" :options="[]"/>
            <x-forms.select label="Witness" name="witness_2" cols="6" class="select-employee" required="required" :options="[]"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Valid ID & ID #" name="valid_id" cols="6" required="required"/>
            <x-forms.input label="Issued at" name="valid_id_issued_at" cols="6" required="required"/>
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-download"></i> Download Contract</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@php
    $employees = \App\Models\Employee::query()
                ->with(['plantilla'])
                ->active()
                ->permanent()
                ->orderBy('lastname')
                ->get()
                ->map(function ($data){
                    return [
                        'id' => $data->slug,
                        'text' => $data->full['FMiLE'],
                    ];
                });
@endphp
@section('scripts')
    <script type="text/javascript">
        let active = '';
        requestsTbl = $("#requests-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.hr_requests.my_index')}}',
            columns: [
                {data: 'created_at', name: 'created_at'},
                {data: 'document', name: 'document'},
                {data: 'tracking_no', name: 'tracking_no'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top',
                }
            ],
            order:[[2,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        requestsTbl.search(this.value).draw();
                    }
                });

                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    requestsTbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
                    active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
                    toast('info','Leave application successfully updated..','Updated!');
                    window.history.pushState({}, document.title, "/dashboard/leave_application/user_index");
                },700);
                @endif
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("body").on("click",".show-timeline-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.hr_requests.show_timeline","slug")}}';
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
        $("body").on("click",".download-cos-btn",function (){
            let route = '{{route('dashboard.hr_requests.download','slug')}}';
            route = route.replace('slug',$(this).attr('data'));
            $("#download-cos-form").attr('action',route);
        })

        let employees = {!! json_encode($employees) !!}
        $(document).ready(function (){
            $(".select-employee").select2({
                data : employees,
                dropdownParent: $("#download-cos-modal"),
            })
        })


    </script>
@endsection