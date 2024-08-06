@extends('layouts.admin-master')

@section('content')

@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">

            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div id="employeeScrollable"></div>

                    </div>
                    <div class="col-md-9">
                        <div id="template">
                            <div id="template_placeholder" class='text-center' style="margin-top: 200px">
                                <h1><span style="font-size: 84px; color: grey"><i class="fa fa-user"></i></span></h1>
                                <p>Please select an employee first.</p>

                            </div>
                        </div>

                        <div class="text-center hidden" style="padding: 25%" id="laoderxx">
                            <i class="fa fa-circle-o-notch fa-spin" style="font-size: 50px"></i>
                        </div>
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
        modal_laoderxx = $("#modal_laoderxx").parent('div').html();
        //Initialize DataTable
        var active = '';

        var empScrollable = new scrollableTable('empScrollable','employeeScrollable');
        empScrollable.setTableHeader(["Name"]);
        var testData = {!! $emps->map(function ($data){
                return [
                    'full_name' => $data->full_name,
                    'employee_no' => $data->employee_no,
                    'slug' => $data->slug,
                ];
            }) !!};
        empScrollable.setTableHeight( () => {return $( window ).height() } );
        empScrollable.setTableContent(testData,"testDataEventType", ["full_name"]);

        $( document ).on("testDataEventType", function(event, data) {
            var url = '{{route("dashboard.payroll_template.edit","slug")}}';
            url = url.replace('slug',data.data.slug);
            let laoderxx = $("#laoderxx");
            laoderxx.removeClass('hidden');
            $("#template").html('');
            $.ajax({
                url : url,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    laoderxx.addClass('hidden');
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

                },
                error: function (res) {
                    laoderxx.addClass('hidden');
                }
            })
        })

        $("body").on("click","#update-all-tax-rates-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.payroll_template.index")}}?updateAllTaxRates=true';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {

                },
                error: function (res) {

                }
            })
        })
    </script>
@endsection