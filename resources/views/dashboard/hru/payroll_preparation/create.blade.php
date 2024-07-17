@extends('layouts.admin-master')

@section('content')

@endsection
@section('content2')

    <section class="content">
        <form id="prepare_payroll_form">
            <div class="box box-solid">
                <div class="box-header">
                    Payroll Preparation
                    <button type="submit" class="pull-right btn btn-primary btn-sm"> <i class="fa fa-chevron-right"></i> Next </button>
                </div>
                <div class="box-body">
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date',[
                            'label' => 'Payroll Date:',
                            'cols' => 3,
                            'type' => 'date',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('type',[
                            'label' => 'Payroll Type:',
                            'cols' => 3,
                            'options' => \App\Swep\Helpers\Arrays::payrollTypes(),
                            'id' => 'payroll_type',
                        ]) !!}
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                BOX A (CERTIFIED)
                            </p>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('a_name',[
                                    'label' => 'Name:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['a_name']) !!}
                                {!! \App\Swep\ViewHelpers\__form2::textbox('a_position',[
                                    'label' => 'Position:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['a_position']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                BOX B (Head, Accounting Unit)
                            </p>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('b_name',[
                                    'label' => 'Name:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['b_name']) !!}
                                {!! \App\Swep\ViewHelpers\__form2::textbox('b_position',[
                                    'label' => 'Position:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['b_position']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                BOX C (Head of the Agency/Representative)
                            </p>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('c_name',[
                                    'label' => 'Name:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['c_name']) !!}
                                {!! \App\Swep\ViewHelpers\__form2::textbox('c_position',[
                                    'label' => 'Position:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['c_position']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                BOX D (Disbursing Officer)
                            </p>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('d_name',[
                                    'label' => 'Name:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['d_name']) !!}
                                {!! \App\Swep\ViewHelpers\__form2::textbox('d_position',[
                                    'label' => 'Position:',
                                    'cols' => 12,
                                ],\App\Swep\Helpers\Values::payrollBoxes()['d_position']) !!}
                            </div>
                        </div>
                    </div>
                    <div id="emplytbl" style="border-top: 1px solid lightgrey; padding: 10px 0px">

                    </div>
                    <div class="text-center hidden" style="padding: 8%" id="tblLoader">
                        <i class="fa fa-circle-o-notch fa-spin" style="font-size: 50px"></i>
                    </div>

                </div>
            </div>

        </form>
    </section>

@endsection


@section('modals')
@endsection


@section('scripts')
    <script type="text/javascript">

        $("#prepare_payroll_form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.payroll_preparation.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('success','Please wait for a while while. Redirecting...','Success!');
                    let url = '{{route("dashboard.payroll_preparation.edit","slug")}}';
                    url = url.replace('slug',res.slug);
                    window.location.href = url;
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on('keyup','#search',function (){
            myFunction();
        });
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("employees_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        $("#payroll_type").change(function (){

            let type=$(this).val();
            $("#emplytbl").html('');
            $("#tblLoader").removeClass('hidden');
            $.ajax({
                url : '{{route("dashboard.payroll_preparation.create")}}?update_table=true',
                data : {
                    type:type,
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#emplytbl").html(res)
                    $("#tblLoader").addClass('hidden');
                },
                error: function (res) {
                    $("#tblLoader").addClass('hidden');
                    
                }
            })
        });

        $("body").on('ifUnchecked','#overall_selector',function (event){
            $('.emp_selector').iCheck('uncheck');
        })
        $("body").on('ifChecked','#overall_selector',function (event){
            $('.emp_selector').iCheck('check');

        })

        $("body").on('ifChanged','.emp_selector',function (event){
            setTimeout(function (){
                let selected = $(".checkbox-counter.checked").length;
                let total = parseInt($("span#total").html());
                $("#checked").html(selected);
                if(selected === 0){
                    $("#overall_selector").iCheck('uncheck');
                }else if(selected === total){
                    $("#overall_selector").iCheck('check');
                }else{
                    $("#overall_selector").iCheck('indeterminate');
                }
            },100)
        })

        function updateMainCheckbox(){
            setTimeout(function (){
                console.log($(".checkbox-counter.checked").length);
            },100)
        }
    </script>
@endsection