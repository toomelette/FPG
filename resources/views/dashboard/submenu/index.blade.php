@extends('layouts.modal-content')

@section('modal-header')
    <b><i class="fa {{$menu->icon}}"></i> {{ $menu->name }}</b> | {{ $menu->route }}
@endsection

@section('modal-body')
    @php
        $rand = \Illuminate\Support\Str::random(10);
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <div class="row">
                    <form id="add_submenu_form_{{$rand}}" data="{{ $menu->slug}}" autocomplete="off">
                        @csrf
                        <p class="page-header-sm text-center">Add submenu to {{ $menu->name }} </p>
                        {!! __form::textbox(
                            '3 name', 'name', 'text', 'Name: *', 'Name','', '', '', ''
                        ) !!}


                        {!! __form::textbox(
                            '4 route', 'route', 'text', 'Route: *', $menu->route.'.example','', '', '', ''
                        ) !!}

                        {!! __form::textbox(
                            '3 nav_name', 'nav_name', 'text', 'Nav name:', 'Nav name','', '', '', ''
                        ) !!}

                        {!! __form::select_static(
                            '2 is_nav', 'is_nav', 'Is nav: *', '', [
                            'No' => '0',
                            'Yes' => '1',
                            ], '', '', '', ''
                        ) !!}

                        <div class="col-md-12">
                            <span class="small route-helper-{{$rand}}"><a href="#">Index</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Create</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Store</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Edit</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Update</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Delete</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Show</a></span>,
                            <span class="small route-helper-{{$rand}}"><a href="#">Print</a></span>

                            <button type="submit" class="btn bg-green pull-right">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <hr>
    <center>
        <label>{{ $menu->name }} Submenus</label>
    </center>
    <div class="row" id="submenu_table_container" hidden>
        <div class="col-md-12">
            <table class="table table-striped table-bordered" id="submenu_table" style="width: 100% !important">
                <thead>
                <tr class="bg-green">
                    <th>Name</th>
                    <th>Route</th>
                    <th>Nav name</th>
                    <th>Nav</th>
                    <th style="width: 70px !important">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="tbl_loader_submenu">
        <center>
            <img style="width: 100px" src="{{asset("images/loader.gif")}}">
        </center>
    </div>
@endsection

@section('modal-footer')

@endsection

@section('scripts')
    <script>
        $(".edit_submenu_btn").click(function () {
            btn = $(this);
            var slug = btn.attr('data');
            uri = "{{route('dashboard.submenu.edit','slug')}}";
            uri = uri.replace('slug',slug);
            load_modal2(btn);
            $.ajax({
                url: uri,
                type: 'GET',
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    notify('Error','warning');
                    console.log(res);
                }
            })
        });

        $("#add_submenu_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.submenu.store")}}',
                data : form.serialize()+"&menu_id={{$menu->menu_id}}",
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form, true, false);
                    submenu_menu_tbl.draw(false);
                    submenu_tbl_active = res.slug;
                },
                error: function (res) {
                    errored(form,res);
                    console.log(res);
                }
            })
        });

        // $("body").on("click",'.edit_submenu_btn',function () {
        //     alert();
        // });
        function edit_submenu_modal(slug){
            btn = $(".edit_submenu_btn[data='"+slug+"']");
            load_modal2(btn);
            var uri = "{{route('dashboard.submenu.edit','slug')}}";
            var uri = uri.replace('slug',slug);
            $.ajax({
                url : uri,
                type: 'GET',
                success: function (res) {
                   populate_modal2(btn,res);
                },
                error: function (res) {
                    console.log(res);
                }
            })
        }



        $(document).ready(function () {

            submenu_tbl_active = '';
            //Initialize DataTable
            submenu_menu_tbl = $("#submenu_table").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax" : '{{ route("dashboard.submenu.fetch") }}?menu_id={{$menu->menu_id}}',
                "columns": [
                    { "data": "name" },
                    { "data": "route" },
                    { "data": "nav_name" },
                    { "data": "is_nav" },
                    { "data": "action" }
                ],
                // buttons: [
                //     'copy', 'excel', 'pdf'
                // ],
                "columnDefs":[
                    {
                        "targets" : 0,
                        "class" : 'w-30p'
                    },
                    {
                        "targets" : 4,
                        "orderable" : false,
                        "class" : 'action-60'
                    },
                    {
                        "targets" : 2,
                        "class" : 'w-15p'
                    },
                    {
                        "targets" : 3,
                        "class" : 'text-center'
                    },
                ],
                "order" : [[0, 'asc']],
                "responsive": false,
                "initComplete": function( settings, json ) {
                    $('#tbl_loader_submenu').fadeOut(function(){
                        $("#submenu_table_container").fadeIn();
                    });
                },
                "language":
                    {
                        "processing": "<center><img style='width: 70px' src='{{asset('images/loader.gif')}}'></center>",
                    },
                "drawCallback": function(settings){
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="modal"]').tooltip();
                    if(submenu_tbl_active != ''){
                        $("#submenu_table #"+submenu_tbl_active).addClass('success');
                    }
                }
            })
        })

        $(".route-helper-{{$rand}}").click(function (){
            let form = $("#add_submenu_form_{{$rand}}");
            let span = $(this);
            let a = span.children('a');
            form.find('input[name="name"]').val(a.html());
            form.find('input[name="route"]').val('{{$menu->route}}'+'.'+a.html().toLowerCase());
            if(a.html() === 'Index'){
                form.find('input[name="nav_name"]').val('Manage');
                form.find('select[name="is_nav"]').val('1');
            }else {
                form.find('input[name="nav_name"]').val('');
                form.find('select[name="is_nav"]').val('0');
            }

        })
    </script>
@endsection

