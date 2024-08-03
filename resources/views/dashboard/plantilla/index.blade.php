@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    <h1>Plantilla Items</h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">List of Plantilla Items</h3>
            <div class="pull-right">
                <button class="btn btn-primary btn-sm" data-target="#add_item_modal" data-toggle="modal"><i class="fa fa-plus"></i> Add item</button>
            </div>
        </div>
        <div class="box-body">
            <div id="plantilla_table_container" style="display: none">
                <table class="table table-bordered table-striped table-hover" id="plantilla_table" style="width: 100% !important">
                    <thead>
                    <tr class="">
                        <th class="th-20">Item No.</th>
                        <th >Position</th>
                        <th >Original JG-SI</th>
                        <th >Incumbent Employee</th>
                        <th class="action">Action</th>
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
    {!! \App\Swep\ViewHelpers\__html::blank_modal('show_item_modal','') !!}
    {!! \App\Swep\ViewHelpers\__html::blank_modal('edit_item_modal','') !!}
@endsection

@section('scripts')
<script type="text/javascript">
    function dt_draw() {
        users_table.draw(false);
    }

    function filter_dt() {
        is_online = $(".filter_status").val();
        is_active = $(".filter_account").val();
        users_table.ajax.url("{{ route('dashboard.user.index') }}" + "?is_online=" + is_online + "&is_active=" + is_active).load();

        $(".filters").each(function (index, el) {
            if ($(this).val() != '') {
                $(this).parent("div").addClass('has-success');
                $(this).siblings('label').addClass('text-green');
            } else {
                $(this).parent("div").removeClass('has-success');
                $(this).siblings('label').removeClass('text-green');
            }
        });
    }
</script>
<script type="text/javascript">
    //-----DATATABLES-----//
    modal_loader = $("#modal_loader").parent('div').html();
    //Initialize DataTable
    var active = '';
    plantilla_tbl = $("#plantilla_table").DataTable({
        "ajax" : '{{\Illuminate\Support\Facades\Request::url()}}',
        "columns": [
            { "data": "item_no" },
            { "data": "position" },
            { "data": "orig_jg_si" },
            { "data": "incumbent" },
            { "data": "action" }
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : [0,2],
                "class" : 'w-8p',
            },
            {
                "targets" : 1,
                "class" : 'w-40p align-top',
            },
            {
                "targets" : 4,
                "orderable" : false,
                "class" : 'action3'
            },
        ],
        "responsive": false,
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "initComplete": function( settings, json ) {
            style_datatable("#"+settings.sTableId);
            $('#tbl_loader').fadeOut(function(){
                $("#"+settings.sTableId+"_container").fadeIn();
                if(find != ''){
                    plantilla_tbl.search(find).draw();
                }
            });
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    plantilla_tbl.search(this.value).draw();
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

    $("body").on("click",".show_item_btn",function () {
        let btn = $(this);
        load_modal2(btn);
        $.ajax({
            url : btn.attr('uri'),
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

    $("body").on("click",".edit_item_btn",function () {
        let btn = $(this);
        load_modal2(btn);
        $.ajax({
            url : btn.attr('uri'),
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
               populate_modal2(btn, res);
            },
            error: function (res) {
                populate_modal2_error(res);
            }
        })
    })

    $("body").on("click",".mark_as_vacant_btn", function () {
        btn = $(this);
        var id = btn.attr('data');
        Swal.fire({
            title: 'Mark item as vacant?',
            // input: 'text',
            html: btn.attr('text'),
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-check"></i> Mark',
            showLoaderOnConfirm: true,
            preConfirm: (email) => {
                return $.ajax({
                    url : '{{route('dashboard.plantilla.index')}}?mark_as_vacant=true',
                    type: 'GET',
                    data: {'id':id},
                    headers: {
                        {!! __html::token_header() !!}
                    },
                })
                    .then(response => {
                        return  response;
                    })
                    .catch(error => {
                        console.log(error);
                        Swal.showValidationMessage(
                            'Error : '+ error.responseJSON.message,
                        )
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {

                notify('Updated successfully');
                active = id;
                plantilla_tbl.draw(false);

            }
        })
    })
</script>

    @endsection