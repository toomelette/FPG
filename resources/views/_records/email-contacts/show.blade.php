@php
    /** @var \App\Models\EmailContact $contact  **/
 @endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$contact->name}}</x-slot:title>
        <x-slot:subtitle>{{$contact->email}}</x-slot:subtitle>
        <x-slot:float-end>Logs</x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="logs-table-container">
        <table class="table table-bordered table-sm" id="logs-table">
            <thead>
            <tr>
                <th style="width: 20px"></th>
                <th>Subject</th>
                <th>Content</th>
                <th style="width: 15%">Email Address</th>
                <th style="width: 95px">Date</th>
                <th style="width: 80px">Status</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
    let active = '';
    logsTbl = $("#logs-table").DataTable({
        dom : 'lBfrtip',
        processing: true,
        serverSide: true,
        ajax : '{{route('dashboard.email_contact.show',$contact->slug)}}',
        columns: [
            { data : "file" },
            { data : "subject" },
            { data : "content" },
            { data : "email" },
            { data : "sent_at"},
            { data : "status" }
        ],
        buttons: [
            {!! __js::dt_buttons() !!}
        ],
        columnDefs:[
            {
                targets : '_all',
                class : 'align-top',
            },
            {
                targets : [4,5],
                class : 'text-center',
            },
        ],
        order:[[4,'desc']],
        responsive: false,
        initComplete: function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    logsTbl.search(this.value).draw();
                }
            });
        },
        drawCallback: function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(active != ''){
                $("#"+settings.sTableId+" #"+active).addClass('table-success');
            }
        }
    })
    </script>
@endsection