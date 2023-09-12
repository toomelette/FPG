@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Cash Receipts <small>Journal Entry Voucher</small>
            <span class="pull-right">JEV: {{$cashReceipt->jev_no}}</span>
        </h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <form id="add_jev_form">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-check"></i> Save</button>
                </div>

                <div class="box-body">
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date',[
                            'label' => 'Date:',
                            'cols' => 2,
                            'type' => 'date',
                        ],$cashReceipt ?? null)   !!}
                        {!! \App\Swep\ViewHelpers\__form2::select('fund_source',[
                            'label' => 'Fund Source:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::acctgFundSources(),
                        ],$cashReceipt ?? null)   !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('collecting_officer',[
                            'label' => 'Collecting Officer:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::collectingOfficers(),
                        ],$cashReceipt ?? null)   !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('rcd_no',[
                            'label' => 'RCD No.:',
                            'cols' => 2,
                        ],$cashReceipt ?? null)   !!}

                        {!! \App\Swep\ViewHelpers\__form2::textarea('remarks',[
                            'label' => 'Explanation:',
                            'cols' => 4,
                        ],$cashReceipt ?? null)   !!}
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
                                        <th style="width: 60px">
                                            <button type="button" id="add_jev_details_btn" class="btn btn-success btn-xs add_btn"><i class="fa fa-plus"></i> Add</button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cashReceipt->details as $jevDetail)
                                            <tr>
                                                <td>
                                                    {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details['.$jevDetail->slug.'][account]',[
                                                        'class' => 'input-sm account',
                                                        'readonly' => 'readonly',
                                                        'copyNameToClass' => 1,
                                                    ],$jevDetail->account_code ?? null) !!}
                                                </td>
                                                <td>
                                                    {!! \App\Swep\ViewHelpers\__form2::selectOnly('jev_details['.$jevDetail->slug.'][account_code]',[
                                                        'class' => 'input-sm select2_account_code init_select2_account_code',
                                                        'options' => [],
                                                        'container_class' => 'select2-sm',
                                                        'copyNameToClass' => 1,
                                                        'select2_preSelected' => ($jevDetail->chartOfAccount->account_title ?? '').' - '.$jevDetail->account_code,
                                                    ],$jevDetail->account_code ?? null) !!}
                                                </td>
                                                <td>
                                                    {!! \App\Swep\ViewHelpers\__form2::selectOnly('jev_details['.$jevDetail->slug.'][resp_center]',[
                                                        'class' => 'input-sm select2-sm select2_resp_center init_select2_resp_center',
                                                        'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(),
                                                        'container_class' => 'select2-sm',
                                                        'copyNameToClass' => 1,
                                                    ],$jevDetail->resp_center ?? null) !!}
                                                </td>
                                                <td>
                                                    {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details['.$jevDetail->slug.'][debit]',[
                                                        'class' => 'input-sm text-right autonum',
                                                        'copyNameToClass' => 1,
                                                    ],$jevDetail->debit ?? null) !!}
                                                </td>
                                                <td>
                                                    {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details['.$jevDetail->slug.'][credit]',[
                                                        'class' => 'input-sm text-right autonum',
                                                        'copyNameToClass' => 1,
                                                    ],$jevDetail->credit ?? null) !!}
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger remove_row_btn"><i class="fa fa-times"></i> </button>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
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
                                        @forelse($cashReceipt->corollaryDetails as $corollaryDetail)
                                            <td>
                                                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][account]',[
                                                    'class' => 'input-sm account',
                                                    'readonly' => 'readonly',
                                                    'copyNameToClass' => 1,
                                                ],$corollaryDetail->account_code ?? null) !!}
                                            </td>
                                            <td>
                                                {!! \App\Swep\ViewHelpers\__form2::selectOnly('corollary_accounts[slug][account_code]',[
                                                    'class' => 'input-sm select2_account_code init_select2_account_code',
                                                    'options' => [],
                                                    'container_class' => 'select2-sm',
                                                    'copyNameToClass' => 1,
                                                    'select2_preSelected' => ($corollaryDetail->chartOfAccount->account_title ?? '').' - '.$corollaryDetail->account_code,
                                                ],$corollaryDetail->account_code ?? null) !!}
                                            </td>
                                            <td>
                                                {!! \App\Swep\ViewHelpers\__form2::selectOnly('corollary_accounts[slug][resp_center]',[
                                                    'class' => 'input-sm select2-sm select2_resp_center init_select2_resp_center',
                                                    'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(),
                                                    'container_class' => 'select2-sm',
                                                    'copyNameToClass' => 1,
                                                ],$corollaryDetail->resp_center ?? null) !!}
                                            </td>
                                            <td>
                                                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][debit]',[
                                                    'class' => 'input-sm text-right autonum',
                                                    'copyNameToClass' => 1,
                                                ],$corollaryDetail->debit ?? null) !!}
                                            </td>
                                            <td>
                                                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][credit]',[
                                                    'class' => 'input-sm text-right autonum',
                                                    'copyNameToClass' => 1,
                                                ],$corollaryDetail->credit ?? null) !!}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove_row_btn"><i class="fa fa-times"></i> </button>
                                            </td>
                                        @empty
                                        @endforelse
                                    </tbody>
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
                    'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(),
                    'container_class' => 'select2-sm',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details[slug][debit]',[
                    'class' => 'input-sm text-right autonum',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details[slug][credit]',[
                    'class' => 'input-sm text-right autonum',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                <button class="btn btn-sm btn-danger remove_row_btn"><i class="fa fa-times"></i> </button>
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
                    'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(),
                    'container_class' => 'select2-sm',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][debit]',[
                    'class' => 'input-sm text-right autonum',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                {!! \App\Swep\ViewHelpers\__form2::textboxOnly('corollary_accounts[slug][credit]',[
                    'class' => 'input-sm text-right autonum',
                    'copyNameToClass' => 1,
                ]) !!}
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove_row_btn"><i class="fa fa-times"></i> </button>
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

        $(".init_select2_resp_center").select2();
        $(".init_select2_account_code").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","account")}}',
                dataType: 'json',
                delay : 250,
            },

            placeholder: 'Select item',
        })
    </script>
@endsection