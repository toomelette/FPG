@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Leave Cards</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="leave-cards-table-container">
            <table class="table table-bordered table-sm" id="leave-cards-table">
                <thead>
                <tr>
                    <th>Employee</th>
                    <th>VL</th>
                    <th>SL</th>
                    <th>Other</th>
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
    <x-adminkit.html.modal id="edit-leave-card-modal"  />
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        leaveCardsTbl = $("#leave-cards-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.leave_card.index')}}',
            columns: [
                { data : "lastname" },
                { data : "vlRemaining" },
                { data : "slRemaining" },
                { data : "details" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[

            ],
            order:[[0,'asc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        leaveCardsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("body").on("click",".edit-leave-card-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.leave_card.beginning_balance","slug")}}';
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