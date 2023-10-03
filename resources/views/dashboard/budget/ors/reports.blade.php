@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Obligation Request and Status - REPORTS</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="nav-tabs">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li role="presentation" class="active"><a href="#ors_summary" data-toggle="tab" aria-expanded="true">ORS Summary</a></li>
                                        <li role="presentation" class=""><a href="#ors_summary_with_projects" data-toggle="tab" aria-expanded="true">ORS Summary with projects</a></li>
                                        <li role="presentation" class=""><a href="#budget_monitoring" data-toggle="tab" aria-expanded="true">Budget Monitoring</a></li>
                                        <li role="presentation" class=""><a href="#statement_of_budget_and_actual_expenditures" data-toggle="tab" aria-expanded="true">Statement of Budget and Actual Expenditures</a></li>
                                        <li role="presentation" class=""><a href="#subsidiary_ledger" data-toggle="tab" aria-expanded="true">Subsidiary Ledger</a></li>
                                        <li role="presentation" class=""><a href="#subsidiary_ledger_2" data-toggle="tab" aria-expanded="true">Subsidiary Ledger 2</a></li>
                                        <li role="presentation" class=""><a href="#budget_proposal_monitoring" data-toggle="tab" aria-expanded="true">Budget Proposal - (Monitoring)</a></li>
                                        <li role="presentation" class=""><a href="#pap_code_monitoring_per_account" data-toggle="tab" aria-expanded="true">PAP Code Monitoring (Per Account)</a></li>
                                        <li role="presentation" class=""><a href="#summary_of_budget_utilization" data-toggle="tab" aria-expanded="true">Summary of Budget Utilization</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content">
                                <div class="tab-pane active" id="ors_summary">
                                    @include('dashboard.budget.ors.reports.ors_summary')
                                </div>

                                <div class="tab-pane" id="ors_summary_with_projects">
                                    @include('dashboard.budget.ors.reports.ors_summary_with_projects')
                                </div>

                                <div class="tab-pane" id="budget_monitoring">
                                    @include('dashboard.budget.ors.reports.budget_monitoring')
                                </div>
                                <div class="tab-pane" id="statement_of_budget_and_actual_expenditures">
                                    @include('dashboard.budget.ors.reports.statement_of_budget_and_actual_expenditures')
                                </div>
                                <div class="tab-pane" id="subsidiary_ledger">
                                    @include('dashboard.budget.ors.reports.subsidiary_ledger')
                                </div>
                                <div class="tab-pane" id="subsidiary_ledger_2">
                                    @include('dashboard.budget.ors.reports.subsidiary_ledger_2')
                                </div>
                                <div class="tab-pane" id="budget_proposal_monitoring">
                                    @include('dashboard.budget.ors.reports.budget_proposal_monitoring')
                                </div>
                                <div class="tab-pane" id="pap_code_monitoring_per_account">
                                    @include('dashboard.budget.ors.reports.pap_code_monitoring_per_account')
                                </div>
                                <div class="tab-pane" id="summary_of_budget_utilization">
                                    @include('dashboard.budget.ors.reports.summary_of_budget_utilization')
                                </div>
                            </div>
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
        $(".generate_report_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let targetFrameId = form.attr('target');
            let baseUrl = form.attr('url');
            let submitBtn = $(this).find('button[type=submit]');
            loading_btn(form);
            $(targetFrameId).attr('src',baseUrl+'?'+form.serialize());
        })

        $(".embed-responsive-item").on('load',function () {
            let frame = $(this);
            let id = frame.attr('id');
            let form = $(".generate_report_form[target='#"+id+"']");
            remove_loading_btn(form);
            frame.parents('.frame-inner-container').siblings('.frame-placeholder').hide();
            frame.parents('.frame-inner-container').show();
        })
        
        $(".print-btn").click(function () {
            let btn = $(this);
            btn.parents('.frame-inner-container').find('iframe').get(0).contentWindow.print();

        })

        $(".generate_excel_btn").click(function () {
            let btn = $(this);
            let iframeId = btn.parents('.frame-inner-container').find('iframe').attr('id');
            let form = $(".generate_report_form[target='#"+iframeId+"']");
            let url = form.attr('url')+'?'+form.serialize()+'&excel=true';
            window.open(url,'_blank');
        })

        $("#sl_accounts").select2();
        $("#sl2_accounts").select2();

        $(".select2_account_code").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","account")}}',
                dataType: 'json',
                delay : 250,
            },

            placeholder: 'Select item',
        });

        $(".select2_pap_code").select2({
            ajax: {
                url: "{{route('dashboard.ajax.get','pap')}}",
            },
            placeholder: 'Select item',
        });
    </script>
@endsection