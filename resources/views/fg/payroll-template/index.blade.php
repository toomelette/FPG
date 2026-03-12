@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Payroll Template</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.accordion id="filter-accordion" class="accordion-sm mb-3 visually-hidden" state="0">
        <x-slot:title>
            <i class="fas fa fa-gear"></i> Utilities
        </x-slot:title>
        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
            <button type="button" class="btn btn-outline-secondary">Update PhilHealth Deductions</button>
            <button type="button" class="btn btn-outline-secondary">Middle</button>
            <button type="button" class="btn btn-outline-secondary">Right</button>
        </div>
    </x-adminkit.html.accordion>

    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Employees ({{$employees->count()}})</h5>
                </div>
                <div class="mb-2 row me-2">
                    <label class="col-form-label col-sm-3 text-sm-end">Search:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="search" placeholder="Search employee" autocomplete="off">
                    </div>
                </div>

                <div style="overflow-y: scroll; height:72vh" id="employee-list-container">
                    <ul class="list-group list-group-flush" id="employee-list">
                        @forelse($employees as $employee)
                            <li class="list-group-item pt-2 pb-2 employee-item" data="{{$employee->slug}}">{{$employee->full['LFEMi']}}</li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9">
            <x-adminkit.html.card style="min-height:81.5vh">
                <div id="template">
                    <div class="text-center" style="padding-top: 30vh">
                        <h1><i class="fa fa-info-circle"></i></h1>
                        <p>Select an employee from the list</p>
                    </div>
                </div>
                <div id="template-placeholder" class="visually-hidden">
                    <div class="text-center" style="padding-top: 30vh">
                        <h1 style="font-size: 50px"><i class="fa fa-circle-notch fa-spin"></i></h1>
                    </div>
                </div>
            </x-adminkit.html.card>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#employee-list .employee-item").click(function (){
            let items = $("#employee-list .employee-item");
            let employee = $(this).attr('data');
            items.each(function (){
                $(this).removeClass('selected');
            });
            $("#template").addClass('visually-hidden');
            $("#template-placeholder").removeClass('visually-hidden');

            let url = '{{route("payroll-template.edit","slug")}}';
            url = url.replace('slug',employee);
            $("#template").html('');
            $.ajax({
                url : url,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#template").html(res);
                    $("#template").removeClass('visually-hidden');
                    $("#template-placeholder").addClass('visually-hidden');
                },
                error: function (res) {

                }
            })


            $(this).addClass('selected');
        })
        @if(Request::has('find'))
        $(document).ready(function (){
            $("li[data='{{Request::get('find')}}']").trigger('click');
            $("li[data='{{Request::get('find')}}']")[0].scrollIntoView({
                behavior: "smooth", // or "auto" or "instant"
                block: "start" // or "end"
            });

        })
        window.history.pushState({}, document.title, "/payroll-template");
        @endif

        $("#search").keyup(function (e){
            search();
        })
        function search() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("employee-list");
            tr = table.getElementsByTagName("li");
            for (i = 0; i < tr.length; i++) {
                td = tr[i];

                if (td) {
                    txtValue = td.html || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection