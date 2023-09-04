@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Obligation and Request Status</h1>
    </section>
@endsection
@section('content2')
    <section class="content">
        <div class="box box-success">
            <form id="ors_form">
                <div class="box-header with-border">
                    <h3 class="box-title">ORS</h3>
                    <div class="pull-right">


                        <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-check"></i> Save</button>
                    </div>

                </div>
                <div class="box-body">

                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::select('funds',[
                                'label' => 'Funds:',
                                'cols' => 1,
                                'options' => \App\Swep\Helpers\Arrays::orsFunds(),
                                'id' => 'select_funds',
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('ors_date',[
                                'label' => 'Date:',
                                'cols' => 2,
                                'type' => 'date',
                            ],Carbon::now()->format('Y-m-d')) !!}
                            {!! \App\Swep\ViewHelpers\__form2::textbox('ors_no',[
                                'label' => 'ORS No:',
                                'cols' => 2,
                                'id' => 'ors_no',
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('payee',[
                                'label' => 'Payee:',
                                'cols' => 4,
                                'id' => 'payee',
                                'autocomplete' => 'off',
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('office',[
                                'label' => 'Office:',
                                'cols' => 3,
                            ]) !!}


                        </div>
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textbox('address',[
                                'label' => 'Address:',
                                'cols' => 3,
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::select('ref_book',[
                                'label' => 'Book:',
                                'cols' => 1,
                                'options' => \App\Swep\Helpers\Arrays::orsBooks(),
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('ref_doc',[
                                'label' => 'Document Ref No:',
                                'cols' => 2,
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textarea('particulars',[
                                'label' => 'Remarks:',
                                'cols' => 4,
                                'rows' => 3,
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('amount',[
                                'label' => 'Amount:',
                                'cols' => 2,
                                'class' => 'text-right autonum'
                            ]) !!}
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                    Certified By
                                </p>
                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::select('certified_by',[
                                        'label' => 'Certified by:',
                                        'cols' => 6,
                                        'id' => 'certified_by_select2',
                                        'options' => [],
                                    ]) !!}
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('certified_by_position',[
                                        'label' => 'Position:',
                                        'cols' => 6,
                                        'id' => 'certified_by_position',

                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                    Budget Certification
                                </p>
                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('certified_budget_by',[
                                        'label' => 'Budget Cert.:',
                                        'cols' => 6,
                                        'list' => 'certified_budget_by',
                                    ], \App\Swep\Helpers\Defaults::budgetCertified()) !!}
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('certified_budget_by_position',[
                                        'label' => 'Position:',
                                        'cols' => 6,
                                        'list' => 'certified_budget_by_position',
                                    ], \App\Swep\Helpers\Defaults::budgetCertifiedPosition()) !!}
                                </div>
                            </div>
                        </div>

                        <div class="nav-tabs-custom tabs-">
                            <ul class="nav nav-tabs">
                                <li class="active text-strong"><a href="#tab_1" data-toggle="tab">Account Entries</a></li>
                                <li class="text-strong"><a href="#tab_2" data-toggle="tab">Applied Projects</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <fieldset id="account_entries_fieldset">
                                        <button type="button" onclick="totalAccountEntries()" hidden>SUM</button>
                                        <button data-target="#account_entries_table" uri="{{route('dashboard.ajax.get','add_row')}}?view=ors_account_entry" style="margin-bottom: 5px" type="button" class="btn btn-xs btn-success pull-right add_button"><i class="fa fa-plus"></i> Add item</button>
                                        <table id="account_entries_table" class="table table-bordered table-striped table-condensed">
                                            <thead>
                                            <tr>
                                                <th style="width: 100px">Type</th>
                                                <th style="width: 25%">Resp Center</th>
                                                <th style="width:120px;">Account Code</th>
                                                <th>Account Title</th>
                                                <th style="width: 130px">Debit</th>
                                                <th style="width: 130px">Credit</th>
                                                <th style="width: 90px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">TOTAL DV</th>
                                                <th id="totalDvDebit" class="text-right"></th>
                                                <th id="totalDvCredit" class="text-right"></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">TOTAL ORS</th>
                                                <th id="totalOrsDebit" class="text-right"></th>
                                                <th id="totalOrsCredit" class="text-right"></th>
                                                <th></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </fieldset>
                                </div>

                                <div class="tab-pane" id="tab_2">

                                    <fieldset id="applied_projects_fieldset">
                                        <button type="button" onclick="totalAppliedProjects()" hidden>SUM</button>
                                        <button data-target="#applied_projects_table" uri="{{route('dashboard.ajax.get','add_row')}}?view=ors_applied_project" style="margin-bottom: 5px" type="button" class="btn btn-xs btn-success pull-right add_button"><i class="fa fa-plus"></i> Add item</button>
                                        <table id="applied_projects_table" class="table table-bordered table-striped table-condensed">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%">Resp Center</th>
                                                <th>PAP</th>
                                                <th style="width: 200px">MOOE</th>
                                                <th style="width: 200px">CO</th>
                                                <th style="width: 50px"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-right">Total</th>
                                                <th id="totalMooe" class="text-right"></th>
                                                <th id="totalCo" class="text-right"></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                </div>
            </form>
        </div>

    </section>

    {!! \App\Swep\Helpers\Helper::listingToDatalist('certified_by',\App\Swep\Helpers\Listing::ors('certified_by')) !!}
    {!! \App\Swep\Helpers\Helper::listingToDatalist('certified_by_position',\App\Swep\Helpers\Listing::ors('certified_by_position')) !!}
    {!! \App\Swep\Helpers\Helper::listingToDatalist('certified_budget_by',\App\Swep\Helpers\Listing::ors('certified_budget_by')) !!}
    {!! \App\Swep\Helpers\Helper::listingToDatalist('certified_budget_by_position',\App\Swep\Helpers\Listing::ors('certified_budget_by_position')) !!}
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        function totalAccountEntries() {
            let form = $("#ors_form");
            let data = form.serialize();
            let arrayByType = new Array();
            $('#account_entries_table tbody tr').each(function () {
                let id = $(this).attr('id');
                let debit = $("#"+id+' input[for=debit]').val();
                let credit = $("#"+id+' input[for=credit]').val();

                if(typeof (arrayByType[$("#"+id+' select[for=type]').val()]) != 'undefined'){
                    arrayByType[$("#"+id+' select[for=type]').val()]['debit'] = arrayByType[$("#"+id+' select[for=type]').val()]['debit'] + sanitizeAutoNum(debit);
                    arrayByType[$("#"+id+' select[for=type]').val()]['credit'] = arrayByType[$("#"+id+' select[for=type]').val()]['credit'] + sanitizeAutoNum(credit);
                }else{
                    arrayByType[$("#"+id+' select[for=type]').val()]= new Array();
                    arrayByType[$("#"+id+' select[for=type]').val()]['debit'] = sanitizeAutoNum(debit);
                    arrayByType[$("#"+id+' select[for=type]').val()]['credit'] = sanitizeAutoNum(credit);

                }
            })

            if(typeof  arrayByType['DV'] != 'undefined'){
                $("#totalDvDebit").html($.number(arrayByType['DV']['debit'],2));
                $("#totalDvCredit").html($.number(arrayByType['DV']['credit'],2));
            }else{
                $("#totalDvDebit").html('N/A');
                $("#totalDvCredit").html('N/A');
            }
            if(typeof (arrayByType['ORS']) != "undefined"){
                $("#totalOrsDebit").html($.number(arrayByType['ORS']['debit'],2));
                $("#totalOrsCredit").html($.number(arrayByType['ORS']['credit'],2));
            }else{
                $("#totalOrsDebit").html('N/A');
                $("#totalOrsCredit").html('N/A');
            }
        }
        
        function totalAppliedProjects() {
            let array = new Array()
            array['mooe'] = 0;
            array['co'] = 0;
            $("#applied_projects_table tbody tr").each(function () {
                if($(this).find('input[for=mooe]').val() !== ''){
                    array['mooe'] = array['mooe'] + sanitizeAutoNum($(this).find('input[for=mooe]').val());
                }
                if($(this).find('input[for=co]').val() !== ''){
                    array['co'] = array['co'] + sanitizeAutoNum($(this).find('input[for=co]').val());
                }
            })
            $("#totalMooe").html($.number(array['mooe'],2));
            $("#totalCo").html($.number(array['co'],2));
        }

        function sanitizeAutoNum($number){
            return parseFloat($number.replaceAll('₱','').replaceAll(',',''));
        }

        $("#applied_projects_fieldset").change(function () {
            totalAppliedProjects();
        });

        $("#account_entries_fieldset").change(function () {
            totalAccountEntries();
        });

        $("body").on("click",".remove_row_btn",function () {
            totalAppliedProjects();
            totalAccountEntries();
        })

        $(document).ready(function () {
            $(".add_button").each(function () {
                $(this).trigger('click');
            })
        })

        $("body").on("change",".resp_center_clear",function () {
            let id = $(this).parents('tr').attr('id');
            $('#select2_id_'+id).val(null).trigger('change');

        })

        $("#ors_form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.ors.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    let print = "{{route('dashboard.ors.print','slug')}}";
                    let edit = "{{route('dashboard.ors.edit','slug')}}";
                    print = print.replace('slug',res.slug)+'?withOrsEntries=true&accountEntriesPerPage=15';
                    edit = edit.replace('slug',res.slug);

                    Swal.fire({
                        title: 'ORS successfully saved',
                        icon: 'success',
                        html: '<p>Choose what you want to do next.</p>',
                        showDenyButton: true,
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnDeny: false,
                        confirmButtonText: '<i class="fa fa-print"></i> Print ORS',
                        denyButtonText: '<i class="fa fa-edit"></i> Edit previous',
                        cancelButtonText: '<i class="fa fa-plus"></i> New ORS',
                        preConfirm: (e) => {
                            window.open(print,'_blank');
                            return false;
                        },
                        preDeny : (e) => {
                            window.open(edit,'_blank');
                            return false;
                        },
                    })

                    toast('success','ORS successfully saved.' ,'Success',10000);
                    // toast('success','ORS successfully saved.  <a href="'+print+'" target="_blank">PRINT with ORS Entries</a> or <a href="'+edit+'" target="_blank">EDIT</a>' ,'Success',10000);
                    $(".remove_row_btn").each(function () {
                        $(this).trigger('click');
                    })
                    $(".add_button").each(function () {
                        $(this).trigger('click');
                    })
                    $("a[href='#tab_1']").trigger('click');
                    $("select[name='funds']").show().focus().click();
                    markTabs(form)
                },
                error: function (res) {
                    errored(form,res);
                    markTabs(form);

                }
            })
        })

        $("body").on("click",".clone_btn",function () {
            let btn = $(this);
            let id = btn.parents('tr').attr('id');
            $.ajax({
                url : '{{route("dashboard.ajax.get","orsAccountEntry")}}',
                data : {
                    type: $('#'+id+' select[for=type]').val(),
                    resp_center : $('#'+id+' select[for=resp_center]').val(),
                    account_code : $('#'+id+' input[for=account_code]').val(),
                    account_title : $('#'+id+' select[for=account_title]').val(),
                    debit : $('#'+id+' input[for=debit]').val(),
                    credit : $('#'+id+' input[for=credit]').val(),
                    select2_text : $('#'+id+' input[for=text-value]').val(),
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#account_entries_table tbody").append(res);
                    totalAccountEntries();
                },
                error: function (res) {
                    console.log(res);
                }
            });
        });


        $(document).on('focus', '.select2.select2-container', function (e) {
            // only open on original attempt - close focus event should not fire open
            if (e.originalEvent && $(this).find(".select2-selection--single").length > 0) {
                $(this).siblings('select').select2('open');
            }
        });

        $("body").on('change','.ors_dv',function () {
            $(this).parents('tr').removeClass('row-ORS');
            $(this).parents('tr').removeClass('row-DV');
            $(this).parents('tr').addClass('row-'+$(this).val());
        })

        //get next ors number based on fund
        $("#select_funds").change(function () {
            let fund = $(this).val();
            $(document.body).css({'cursor' : 'wait'});
            $.ajax({
                url : '{{route("dashboard.ajax.get","nextOrsNo")}}',
                data : {fund: fund},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#ors_no").val(res.newOrsNumber);
                    $(document.body).css({'cursor' : 'default'});
                },
                error: function (res) {
                    $(document.body).css({'cursor' : 'default'});
                }
            })
        })
        $("#payee").typeahead({
            ajax : "{{ route('dashboard.ajax.get','ors_payees') }}?typeahead=true",
        });

        $('#certified_by_select2').select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","ors_certified_by")}}',
                dataType: 'json',
                delay : 250,
            },
            placeholder: 'Select item',
        });

        $('#certified_by_select2').on('select2:select', function (e) {
            let data = e.params.data;
            $("#certified_by_position").val(data.position);
        });


        window.addEventListener('keydown', function(e) {
            if (e.altKey == true && e.keyCode == 78)
                $(".add_button").trigger('click');
        });



    </script>
@endsection