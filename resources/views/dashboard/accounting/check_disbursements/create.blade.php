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
                        Check Disbursements <small>Journal Entry Voucher</small>
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

                                {!! \App\Swep\ViewHelpers\__form2::textbox('payee',[
                                    'label' => 'Payee:',
                                    'cols' => 4,
                                ])   !!}
                            </div>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('cd_no',[
                                    'label' => 'ChkDR.:',
                                    'cols' => 4,
                                ])   !!}

                                {!! \App\Swep\ViewHelpers\__form2::textbox('check_from',[
                                    'label' => 'Check No From:',
                                    'cols' => 4,
                                ])   !!}
                                {!! \App\Swep\ViewHelpers\__form2::textbox('check_to',[
                                    'label' => 'Check No To:',
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
                            <li class="text-strong hidden"><a href="#tab_2" data-toggle="tab">Corollary Accounts</a></li>
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
                                        <th style="width: 60px">
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
        <tr id="row_slug">
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details[slug][account]',[
                    'class' => 'input-sm account',
                    'readonly' => 'readonly',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::selectOnly('jev_details[slug][account_code]',[
                    'class' => 'input-sm select2_account_code',
                    'options' => [],
                    'container_class' => 'select2-sm',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::selectOnly('jev_details[slug][resp_center]',[
                    'class' => 'input-sm select2-sm select2_resp_center',
                    'options' => \App\Swep\Helpers\Arrays::departmentListAbbv(),
                    'container_class' => 'select2-sm',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details[slug][debit]',[
                    'class' => 'input-sm text-right autonum debit debit_credit',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details[slug][credit]',[
                    'class' => 'input-sm text-right autonum credit debit_credit',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                <button class="btn btn-sm btn-danger remove_row_btn" tabindex="-1"><i class="fa fa-times"></i> </button>
            </td>
        </tr>
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
    </table>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#add_jev_details_btn").click(function (){
            let jevTbl = $("#jev_details_table");
            let rand = makeId(10);
            let jevDetailsRowTemplate = $("#jev_details_row_template").html().replaceAll('slug',rand);

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
            $.ajax({
                url : '{{route("dashboard.check_disbursements.store")}}',
                data : form.serialize(),
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
                    $('.totals').each(function (){
                        $(this).html('0.00');
                    })
                },
                error: function (res) {
                    errored(form,res);
                    markTabs(form);
                }
            })
        })

        $("body").on('change keyup','.debit_credit',function (){
            let table = $(this).parents('table');
            let allDebitFields = table.find('.debit');
            let allCreditFields = table.find('.credit');
            let totalDebit = 0;
            let totalCredit = 0;

            allDebitFields.each(function (){
                let amt = sanitizeAutonum($(this).val());
                totalDebit = totalDebit + amt;
            })
            allCreditFields.each(function (){
                let amt = sanitizeAutonum($(this).val());
                totalCredit = totalCredit + amt;
            })
            table.find('.debit_total').html($.number(totalDebit,2));
            table.find('.credit_total').html($.number(totalCredit,2))
        })

        makeSubmenuActive('{{\Illuminate\Support\Facades\URL::route('dashboard.cash_receipts.create')}}');
    </script>


@endsection