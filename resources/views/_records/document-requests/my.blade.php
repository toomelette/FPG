@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>My Requests</x-slot:title>
        <x-slot:subtitle>Release of Documents/Records</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title><button type="button" class="btn btn-sm btn-primary float-end" data-bs-target="#add-request-modal" data-bs-toggle="modal"><i class="fa fa-plus"> </i> Make Request</button></x-slot:title>

        <div class="document-requests-table-container">
            <table class="table table-bordered table-sm" id="document-requests-table">
                <thead>
                <tr>
                    <th>Request No</th>
                    <th>Date Requested</th>
                    <th>Requested by</th>
                    <th>Requested Records</th>
                    <th style="width: 80px">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-request-modal" form-id="add-request-form">
        <x-slot:title>Make request for release of documents/records</x-slot:title>
        <div class="row mb-2">
            <x-forms.checkbox type="radio" label="Requesting party" name="requesting_party" cols="12" :options="\App\Swep\Helpers\Arrays::documentRequestingParty()" each-class="6"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Specify requesting party" name="requesting_party_specify" cols="md-12" container-class="visually-hidden"/>
        </div>
        <div class="row mb-3">
            <x-forms.textarea label="Requested records/documents" name="requested_records" cols="md-12"/>
        </div>
        <div class="row mb-2">
            <x-forms.checkbox type="radio" label="Purpose" name="purpose" cols="md-12" :options="\App\Swep\Helpers\Arrays::documentRequestPurpose()" each-class="12 mb-1"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Specify purpose" name="purpose_specify" cols="md-12" container-class="visually-hidden"/>
        </div>

        <div class="row mb-3">
            <x-forms.input label="Requested by" name="requested_by" cols="6" :value="trim(Auth::user()->employee->full['FMiLE'] ?? null)"/>
            <x-forms.input label="Position" name="requested_by_position" cols="6" :value="Auth::user()->employee->plantilla->position ?? Auth::user()->employee->position ?? null"/>
        </div>

        <div class="row mb-3">
            <x-forms.input label="Contact Details" name="contact_details" cols="12"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-document-request-modal"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        requestsTbl = $("#document-requests-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.document_request.my')}}',
            columns: [
                { data : "request_no" },
                { data : "requested_at" },
                { data : "requested_by" },
                { data : "requested_records" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                
            ],
            order:[[0,'desc']],
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
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
    </script>
    @include('_records.document-requests.js')
@endsection