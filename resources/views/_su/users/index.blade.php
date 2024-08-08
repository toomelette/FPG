@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Users</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="users-table-container">
            <table class="table table-bordered table-sm" id="users-table">
                <thead>
                <tr>
                    <th style="width: 15%;">Username</th>
                    <th>Employee</th>
                    <th>First</th>
                    <th>Middle</th>
                    <th style="width: 50px">Active</th>
                    <th style="width: 50px">Online</th>
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

@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        usersTbl = $("#users-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.user.index')}}',
            columns: [
                { data : "username" },
                { data : "fullname", name: "employee.lastname" },
                { data : "employee.firstname" },
                { data : "employee.middlename" },
                { data : "is_activated" },
                { data : "last_activity" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets: [2,3],
                    visible: false,
                }
            ],
            order:[[5,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        usersTbl.search(this.value).draw();
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
@endsection