@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        @include('dashboard.accounting.jev.tabs-top')
    </section>
@endsection
@section('content2')


    <section class="content">
        <form id="add_jev_form">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Cash Receipts <small>Journal Entry Voucher</small>
                    </h3>
                    <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-check"></i> Save</button>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('date',[
                                    'label' => 'Date:',
                                    'cols' => 4,
                                    'type' => 'date',
                                ])   !!}
                                {!! \App\Swep\ViewHelpers\__form2::select('fund_source',[
                                    'label' => 'Fund Source:',
                                    'cols' => 4,
                                    'options' => \App\Swep\Helpers\Arrays::acctgFundSources(),
                                ])   !!}

                                {!! \App\Swep\ViewHelpers\__form2::select('collecting_officer',[
                                    'label' => 'Collecting Officer:',
                                    'cols' => 4,
                                    'options' => \App\Swep\Helpers\Arrays::collectingOfficers(),
                                ])   !!}
                            </div>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('rcd_no',[
                                    'label' => 'RCD No.:',
                                    'cols' => 4,
                                ])   !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textarea('remarks',[
                                    'label' => 'Explanation:',
                                    'cols' => 12,
                                    'rows' => 5,
                                ])   !!}
                            </div>
                        </div>
                    </div>


                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active text-strong"><a href="#tab_1" data-toggle="tab">JEV Details</a></li>
                            <li class="text-strong"><a href="#tab_2" data-toggle="tab">Corollary Accounts</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <table id="jev_details_table" class="table table-condensed table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%;">Account Code</th>
                                        <th style="width: 30%;">Account Title</th>
                                        <th>Resp Center</th>
                                        <th style="width: 10%;">Debit</th>
                                        <th style="width: 10%;">Credit</th>
                                        <th style="width: 110px">
                                            <button type="button" id="add_jev_details_btn" class="btn btn-success btn-xs add_btn"><i class="fa fa-plus"></i> Add</button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">TOTAL</th>
                                        <th class="totals debit_total text-right">0.00</th>
                                        <th class="totals credit_total text-right">0.00</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab_2">
                                {!! \App\Swep\ViewHelpers\__form2::textarea('remarks2',[
                                    'label' => 'Explanation:',
                                    'cols' => 12,
                                    'rows' => 2,
                                ])   !!}
                                <table id="corollary_accounts_table" class="table table-condensed table-bordered table-striped">
                                    <thead>
                                    <tr class="bg-info">
                                        <th style="width: 10%;">Account Code</th>
                                        <th style="width: 30%;">Account Title</th>
                                        <th>Resp Center</th>
                                        <th style="width: 10%;">Debit</th>
                                        <th style="width: 10%;">Credit</th>
                                        <th style="width: 60px">
                                            <button type="button" id="add_corollary_account_btn" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">TOTAL</th>
                                        <th class="totals debit_total text-right">0.00</th>
                                        <th class="totals credit_total text-right">0.00</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>


                        </div>

                    </div>



                </div>

            </div>
        </form>

    </section>

    <table  class="table table-condensed table-bordered table-striped" style="display: none">
        <tbody id="jev_details_row_template">
        @include('dashboard.accounting.jev.jev_detail_template',[
            'slug' => 'slug',
            'jevDetail' => null,
        ])
        </tbody>
        <tbody id="corollary_account_row_template">
        <tr id="row_slug">
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][account]',[
                    'class' => 'input-sm account',
                    'readonly' => 'readonly',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::selectOnly('corollary_accounts[slug][account_code]',[
                    'class' => 'input-sm select2_account_code',
                    'options' => [],
                    'container_class' => 'select2-sm',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::selectOnly('corollary_accounts[slug][resp_center]',[
                    'class' => 'input-sm select2-sm select2_resp_center',
                    'options' => \App\Swep\Helpers\Arrays::departmentListAbbv(),
                    'container_class' => 'select2-sm',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][debit]',[
                    'class' => 'input-sm text-right autonum debit debit_credit',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][credit]',[
                    'class' => 'input-sm text-right autonum credit debit_credit',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove_row_btn" tabindex="-1"><i class="fa fa-times"></i> </button>
            </td>
        </tr>
        </tbody>
        <tbody id="sl_row_template">
        @include('dashboard.accounting.jev.sl_row_template',[
            'parentSlug' => 'slug',
            'rowSlug' => 'newRand',
            'jevDetail' => null,
            'subsidiaryLedger' => null,
        ])
        </tbody>

    </table>

    <div id="subsidiary_ledgers_container">
        <table>
            <tbody>
                <tr>

                </tr>
            </tbody>
        </table>
    </div>
@endsection


@section('modals')
    <div id="sl_modals">

    </div>
    <div id="sl_modal_template">
        @include('dashboard.accounting.jev.sl_modal_template',[
            'slug' => 'slug',
        ])
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        const ajaxUrlForSelect2AccountCode = '{{route("dashboard.ajax.get","account")}}';
    </script>
    <script type="text/javascript" src="{{asset('js/jev.js')}}"></script>
    <script type="text/javascript">
        const saAccounts = JSON.parse('{!! json_encode(\App\Swep\Helpers\Arrays::groupedSubsidiaryAccounts()) !!}');
        const saAccountsAsOptions = makeSelectOptions(saAccounts);
    </script>
    <script type="text/javascript">


        $("#add_corollary_account_btn").click(function (){
            let jevTbl = $("#corollary_accounts_table");
            let rand = makeId(10);
            let jevDetailsRowTemplate = $("#corollary_account_row_template").html().replaceAll('slug',rand);

            jevTbl.find('tbody').append(jevDetailsRowTemplate);
            let newRow = jevTbl.find('#row_'+rand);
            newRow.find('.select2_resp_center').select2();

            //initialize autonum on new inputs
            newRow.find(".autonum").each(function(){
                new AutoNumeric(this, autonum_settings);
            });

            //initialize select2 on account code
            newRow.find(".select2_account_code").select2({
                ajax: {
                    url: '{{route("dashboard.ajax.get","account")}}',
                    dataType: 'json',
                    delay : 250,
                },

                placeholder: 'Select item',
            });

            //populate readonly account code
            $('#row_'+rand+' .select2_account_code').on('select2:select', function (e) {
                let data = e.params.data;
                newRow.find('.account').val(data.id);
            });
        })

        $(document).ready(function (){
            $(".add_btn").each(function (){
                $(this).trigger('click');
            })
        });

        $("#add_jev_form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            formData = form.serializeArray();

            //INCLUDE SUBSIDIARY LEDGERS IN SERIALIZED ARRAY
            $(".sl_form").each(function (){
                let t = $(this);
                let data = $(this).serializeArray();
                $.each(data,function (index,value){
                   formData.push(value);
                });
            });
            $.ajax({
                url : '{{route("dashboard.cash_receipts.store")}}',
                data : formData,
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    $("#jev_details_table tbody").html("");
                    $("#corollary_accounts_table tbody").html("");
                    $(".add_btn").each(function (){
                        $(this).trigger('click');
                    })
                    markTabs(form);
                    jevSuccessfullySubmitted();
                },
                error: function (res) {
                    errored(form,res);
                    markTabs(form);
                }
            })
        })



        $("body").on('change keyup','.debit_credit',function (){
            let table = $(this).parents('table');
            sumDebitAndCreditToFooter(table);
        })
        $("body").on("click",".remove_row_btn",function (){
            let t = $(this);
            let tr = t.parents('tr');
            let id = tr.attr('id');
            let slug = id.replaceAll('row_','');
            $("#sl_modal_"+slug).remove();
        });

    </script>


@endsection