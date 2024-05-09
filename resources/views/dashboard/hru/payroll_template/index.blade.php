@extends('layouts.admin-master')

@section('content')

@endsection
@section('content2')
    @php
        $emps = \App\Models\Employee::query()
            ->permanent()
            ->active()
            ->orderBy('lastname','asc')
            ->get();
    @endphp
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div id="employeeScrollable"></div>

                    </div>
                    <div class="col-md-9" id="template">
                        <div id="template_placeholder" class='text-center' style="margin-top: 200px">
                            <h1><span style="font-size: 84px; color: grey"><i class="fa fa-user"></i></span></h1>
                            <p>Please select an employee first.</p>

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">

                        <input type="file" class="form-control">

                        <button type="button" class="btn btn-block btn-primary">
                            Select File
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>



@endsection


@section('modals')
@endsection


@section('scripts')
    <script type="text/javascript">
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        var active = '';

        var empScrollable = new scrollableTable('empScrollable','employeeScrollable');
        empScrollable.setTableHeader(["Name","Id"]);
        var testData = {!! $emps->map(function ($data){
                return [
                    'full_name' => $data->full_name,
                    'employee_no' => $data->employee_no,
                    'slug' => $data->slug,
                ];
            }) !!};
        empScrollable.setTableHeight( () => {return $( window ).height() - 300 } );
        empScrollable.setTableContent(testData,"testDataEventType", ["full_name","employee_no"]);

        $( document ).on("testDataEventType", function(event, data) {
            var url = '{{route("dashboard.payroll_template.edit","slug")}}';
            url = url.replace('slug',data.data.slug);
            $.ajax({
                url : url,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#template").html(res);
                },
                error: function (res) {

                }
            })
        });

        $("body").on("click",".view-employee-btn",function (){
            let btn = $(this);
            let slug = btn.attr('data');
            let uri = btn.attr('uri');

            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#template").html(res);

                },
                error: function (res) {

                }
            })

        })
    </script>
@endsection