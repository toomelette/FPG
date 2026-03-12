@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Prepare Payroll</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <form id="prepare-payroll-form">
            <div class="clearfix">
                <button type="submit" class="btn btn-primary float-end"><i class="fa fa-chevron-right"></i> Next</button>
            </div>
            <div class="row mb-4">
                <x-forms.input label="Payroll Date" name="date" cols="3" type="month"/>
                <x-forms.select label="Payroll Type" name="type" cols="3" class="employee-list-trigger" :options="\App\Swep\Helpers\Arrays::payrollTypes()"/>
                <x-forms.input label="Date From" container-class="special-fields"  name="date_from" cols="2" type="date"/>
                <x-forms.input label="Date To" container-class="special-fields" name="date_to" cols="2" type="date"/>
            </div>
            <div class="row mb-3 hide-this" >
                <div class="col-3">
                    <x-adminkit.html.alert type="primary mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        BOX A (CERTIFIED)
                    </x-adminkit.html.alert>

                    <div class="row">
                        <x-forms.input label="Name" name="a_name" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['a_name']"/>
                        <x-forms.input label="Position" name="a_position" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['a_position']"/>
                    </div>
                </div>

                <div class="col-3">
                    <x-adminkit.html.alert type="warning mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        BOX B (Head, Accounting Unit)
                    </x-adminkit.html.alert>

                    <div class="row">
                        <x-forms.input label="Name" name="b_name" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['b_name']"/>
                        <x-forms.input label="Position" name="b_position" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['b_position']"/>
                    </div>
                </div>

                <div class="col-3">
                    <x-adminkit.html.alert type="info mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        BOX C (Head of the Agency/Representative)
                    </x-adminkit.html.alert>

                    <div class="row">
                        <x-forms.input label="Name" name="c_name" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['c_name']"/>
                        <x-forms.input label="Position" name="c_position" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['c_position']"/>
                    </div>
                </div>

                <div class="col-3">
                    <x-adminkit.html.alert type="success mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        BOX D (Disbursing Officer)
                    </x-adminkit.html.alert>

                    <div class="row">
                        <x-forms.input label="Name" name="d_name" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['d_name']"/>
                        <x-forms.input label="Position" name="d_position" cols="12" :value="\App\Swep\Helpers\Values::payrollBoxes()['d_position']"/>
                    </div>
                </div>
            </div>

            <div id="employees-table" style="border-top: 1px solid lightgrey; padding: 10px 0px">

            </div>
            <div class="text-center visually-hidden" style="padding: 8%" id="loading-placeholder">
                <i class="fa fa-circle-notch fa-spin" style="font-size: 50px"></i>
            </div>
        </form>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#prepare-payroll-form").submit(function (e) {

            e.preventDefault()
            let form = $(this);
            console.log(form.serialize());
            loading_btn(form);
            $.ajax({
                url : '{{route("payroll-preparation.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('success','Please wait for a while while. Redirecting...','Success!');
                    let url = '{{route("payroll-preparation.edit","slug")}}';
                    url = url.replace('slug',res.uuid);
                    window.location.href = url;
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })


        $(".employee-list-trigger").change(function (){
            let type = $("#prepare-payroll-form select[name='type']").val();
            let filterEmployees = $("#prepare-payroll-form select[name='filterEmployees']").val()
            $("#employees-table").html('');
            $("#loading-placeholder").removeClass('visually-hidden');
            /*
            let $specialFields = $(".special-fields");
            $specialFields.each(function (){
                let $element = $(this);
                if ($element.hasClass(type)) {
                    $element.removeClass('hide-this');
                }else{
                    $element.addClass('hide-this');
                }
            });
            */
            $.ajax({
                url : '{{route("payroll-preparation.create")}}?updateTable=true',
                data : {
                    type: type,
                    filterEmployees : filterEmployees,
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#employees-table").html(res)
                    $("#loading-placeholder").addClass('visually-hidden');
                },
                error: function (res) {
                    $("#loading-placeholder").addClass('visually-hidden');

                }
            })
        });

        $("body").on('ifUnchecked','#overall-selector',function (event){
            $('.employee-selector').iCheck('uncheck');
        })
        $("body").on('ifChecked','#overall-selector',function (event){
            $('.employee-selector').iCheck('check');
        })

        $("body").on('ifChanged','.employee-selector',function (event){
            setTimeout(function (){
                let selected = $(".checkbox-counter.checked").length;
                let total = parseInt($("span#total").html());
                $("#checked").html(selected);
                if(selected === 0){
                    $("#overall-selector").iCheck('uncheck');
                }else if(selected === total){
                    $("#overall-selector").iCheck('check');
                }else{
                    $("#overall-selector").iCheck('indeterminate');
                }
            },100)
        })

        function updateMainCheckbox(){
            setTimeout(function (){
                console.log($(".checkbox-counter.checked").length);
            },100)
        }

        $("body").on('keyup','#search',function (){
            searchEmployee();
        });
        function searchEmployee() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("employees-table");
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

        $("body").on('change','.employee-select-payroll-group',function(){
            let tr = $(this).parents('tr');
            let tdPayGroup = tr.children('td').eq(2);
            tdPayGroup.html($(this).val());
        });



    </script>
@endsection