@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>General Journal <small>Journal Entry Voucher</small></h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            {{--            <div class="box-header with-border">--}}
            {{--                <h3 class="box-title">Progress bars</h3>--}}
            {{--            </div>--}}

            <div class="box-body">
                <div id="jev_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="jev_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th>JEV No.</th>
                            <th class="th-20">Date</th>
                            <th class="th-20">Fund</th>
                            <th>Explanation</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="tbl_loader">
                    <center>
                        <img style="width: 100px" src="{{asset('images/loader.gif')}}">
                    </center>
                </div>
            </div>

        </div>

    </section>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            //-----DATATABLES-----//
            modal_loader = $("#modal_loader").parent('div').html();
            //Initialize DataTable
            active = '';
            jev_tbl = $("#jev_table").DataTable({
                "ajax" : '{{\Illuminate\Support\Facades\Request::url()}}',
                "columns": [
                    { "data": "jev_no" },
                    { "data": "date" },
                    { "data": "fund_source" },
                    { "data": "remarks" },
                    { "data": "details" },
                    { "data": "action" }
                ],
                "columnDefs":[
                    {
                        "targets" : 0,
                        "class" : 'w-10p'
                    },
                    {
                        "targets" : [1,2],
                        "class" : 'w-8p'
                    },

                    {
                        "targets" : 5,
                        "orderable" : false,
                        "class" : 'action4'
                    },
                ],
                order : [[0,'desc']],
                "responsive": false,
                'dom' : 'lfrtip',
                "processing": true,
                "serverSide": true,
                "initComplete": function( settings, json ) {
                    style_datatable("#"+settings.sTableId);
                    $('#tbl_loader').fadeOut(function(){
                        $("#"+settings.sTableId+"_container").fadeIn();
                        if(find != ''){
                            jev_tbl.search(find).draw();
                        }
                    });
                    //Need to press enter to search
                    $('#'+settings.sTableId+'_filter input').unbind();
                    $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                        if (e.keyCode == 13) {
                            jev_tbl.search(this.value).draw();
                        }
                    });
                },

                "language":
                    {
                        "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                    },
                "drawCallback": function(settings){
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="modal"]').tooltip();
                    if(active != ''){
                        $("#"+settings.sTableId+" #"+active).addClass('success');
                    }
                }
            });
        })
    </script>
@endsection