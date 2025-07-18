@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>ICT Service Requests</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div id="requests-table-container">
            <table class="table table-bordered table-striped table-sm" id="requests-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th >Rqst #.</th>
                    <th >Requester</th>
                    <th >Nature of Request</th>
                    <th style="width: 15%;">Created at</th>
                    <th style="width: 18%;">Status</th>
                    <th style="width: 120px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-request-modal" size="lg"/>
    <x-adminkit.html.modal id="status-modal" />
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        requestsTbl = $("#requests-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.mis_requests.index')}}',
            columns: [
                { data: "request_no", "name": "request_no" },
                { data: "fullname", "name": "fullname" },
                { data: "nature_of_request", "name": "nature_of_request" },
                { data: "created_at", "name": "created_at" },
                { data: "status", "name": "status" },
                { data: "action", "name": "action" },
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top'
                },
                {
                    targets : 0,
                    class : 'w-6p'
                },
                {
                    targets : 5,
                    orderable : false,
                },
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
        $("body").on("click",".edit-request-btn", function () {
            let btn = $(this);
            let uri = '{{route("dashboard.mis_requests.edit","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            load_modal2(btn);
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
                    toast('error','Ajax error.' ,'Error:');
                    console.log(res);
                }
            })
        })
        $("body").on("click",".update-status-btn",function () {
            let r = $(this).attr('slug');
            let uri = "{{route('dashboard.mis_requests.update','slug')}}?update_status=true";
            uri = uri.replace('slug',$(this).attr('data'));
            Swal.fire({
                title: 'Update status',
                html: 'Request no: <b>'+$(this).attr('request_no')+'</b>',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    return $.ajax({
                        url : uri,
                        data : {'status':text , 'request_slug' : r},
                        type: 'PUT',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            active = res.slug;
                            requestsTbl.draw(false);
                            toast('info','Status was successfully updated.','Success!')
                        },
                        error: function (res) {
                            if(res.status == 422){
                                var message = res.responseJSON.errors.biometric_user_id;
                            }else{
                                var message = res.responseJSON.message;
                            }
                            Swal.showValidationMessage(
                                'Request failed: ' + message
                            );
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                        .catch(error => {
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        });
        $("body").on("click",".mark-as-done-btn",function () {
            let r = $(this).attr('slug');
            let uri = "{{route('dashboard.mis_requests.update','slug')}}?mark_as_done=true";
            uri = uri.replace('slug',$(this).attr('data'));
            Swal.fire({
                title: 'Mark as completed?',
                html: 'Request no: <b>'+$(this).attr('request_no')+'</b>',
                // input: '',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check"></i> Mark',
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    return $.ajax({
                        url : uri,
                        data : {},
                        type: 'PUT',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            active = res.slug;
                            requestsTbl.draw(false);
                            toast('info','Status was successfully updated.','Success!');
                        },
                        error: function (res) {
                            if(res.status == 422){
                                var message = res.responseJSON.errors.biometric_user_id;
                            }else{
                                var message = res.responseJSON.message;
                            }
                            Swal.showValidationMessage(
                                'Request failed: ' + message
                            );
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                        .catch(error => {
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        });

        $("body").on("click",".status-btn",function () {
            btn = $(this);
            let uri = '{{route("dashboard.mis_requests_status.index")}}';
            uri = uri.replace('slug',btn.attr('data'));
            load_modal2(btn);
            $.ajax({
                url : uri,
                data :{slug:btn.attr('data')},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    toast('error','Ajax error.','Error:');
                }
            })
        })
    </script>
@endsection