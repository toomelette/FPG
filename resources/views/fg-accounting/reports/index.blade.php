@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Reports</x-slot:title>
    </x-adminkit.html.page-title>

    <div class="row">
        <div class="col-md-3 col-xl-2">

            <div class="card">
                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active list-group-primary" data-bs-toggle="list" href="#cash-receipts-register" role="tab" aria-selected="true">
                        Cash Receipts Register
                    </a>
                    <a class="list-group-item list-group-item-action list-group-primary" data-bs-toggle="list" href="#cash-disbursements-register" role="tab" aria-selected="false" tabindex="-1">
                        Cash Disbursements Register
                    </a>
                    <a class="list-group-item list-group-item-action list-group-primary" data-bs-toggle="list" href="#general-journal-register" role="tab" aria-selected="false" tabindex="-1">
                        General Journal Register
                    </a>
                    <a class="list-group-item list-group-item-action list-group-primary" data-bs-toggle="list" href="#general-ledger" role="tab" aria-selected="false" tabindex="-1">
                        General Ledger
                    </a>
                    <a class="list-group-item list-group-item-action list-group-primary" data-bs-toggle="list" href="#trial-balance" role="tab" aria-selected="false" tabindex="-1">
                        Trial Balance
                    </a>
                    <a class="list-group-item list-group-item-action list-group-primary" data-bs-toggle="list" href="#analysis-of-accounts" role="tab" aria-selected="false" tabindex="-1">
                        Analysis of Accounts
                    </a>

                    <div class="card-header list-group-custom list-group-success header-success">
                        <h5 class="card-title mb-0">Subsidiary Accounts</h5>
                    </div>
                    <a class="list-group-item list-group-item-action list-group-success" data-bs-toggle="list" href="#subsidiary-ledger" role="tab" aria-selected="false" tabindex="-1">
                        Subsidiary Ledger
                    </a>
                    <a class="list-group-item list-group-item-action list-group-success" data-bs-toggle="list" href="#schedule-of-accounts" role="tab" aria-selected="false" tabindex="-1">
                        Schedule of Accounts
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="cash-receipts-register" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cash Receipts Register</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','journal-register')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="Book" name="book" cols="2" value="CASH RECEIPT" container-class="hide-this" readonly="readonly"/>
                                    <x-forms.input label="Date From" name="date_from" cols="2" type="date"/>
                                    <x-forms.input label="Date To" name="date_to" cols="2" type="date"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="cash-disbursements-register" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cash Disbursements Register</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','journal-register')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="Book" name="book" cols="2" value="CASH DISBURSEMENT" container-class="hide-this" readonly="readonly"/>
                                    <x-forms.input label="Date From" name="date_from" cols="2" type="date"/>
                                    <x-forms.input label="Date To" name="date_to" cols="2" type="date"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="general-journal-register" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">General Journal Register</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','journal-register')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="Book" name="book" cols="2" value="GENERAL JOURNAL" container-class="hide-this" readonly="readonly"/>
                                    <x-forms.input label="Date From" name="date_from" cols="2" type="date"/>
                                    <x-forms.input label="Date To" name="date_to" cols="2" type="date"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="general-ledger" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">General Ledger</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','general-ledger')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="Book" name="book" cols="2" value="GENERAL JOURNAL" container-class="hide-this" readonly="readonly"/>
                                    <x-forms.input label="From" name="month_from" cols="2" type="month"/>
                                    <x-forms.input label="To" name="month_to" cols="2" type="month"/>
                                    <x-forms.select label="Account Code" name="account_code" class="select2-account-codes" cols="4" required="required"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="trial-balance" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Trial Balance</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','trial-balance')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="To" name="month_to" cols="2" type="month"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="analysis-of-accounts" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Analysis of Accounts</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','analysis-of-accounts')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="From" name="date_from" cols="2" type="date"/>
                                    <x-forms.input label="To" name="date_to" cols="2" type="date"/>
                                    <x-forms.select label="Account Code" name="account_code" class="select2-account-codes" cols="4" required="required"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="subsidiary-ledger" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Subsidiary Ledger</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','subsidiary-ledger')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="Date From" name="date_from" cols="2" type="date"/>
                                    <x-forms.input label="Date to" name="date_to" cols="2" type="date" value="{{now()->format('Y-m-d')}}"/>
                                    <x-forms.select label="Account Code" name="account_code" class="select2-account-codes" cols="4"/>
                                    <x-forms.select label="Subsidiary Account Code" name="subsidiary_account_code" class="select2-subsidiary-account-codes" cols="4" required="required"/>

                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="schedule-of-accounts" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Schedule of Accounts</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('accounting-reports.print','schedule-of-accounts')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="As of" name="date_to" cols="2" type="month"/>
                                    <x-forms.select label="Account Code" name="account_code" class="select2-account-codes" cols="4"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-secondary mb-2 float-end print-btn"><i class="fa fa-print"></i> Print</button>
                            <div class="embed-responsive">
                                <iframe height="600" class="embed-responsive-item" src="" style="padding: 10px"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $(".report-form").submit(function (e){
            e.preventDefault();
            let form = $(this);
            let route = form.attr('target');
            let params = form.serialize();
            let target = route+'?'+params;
            let iframe = form.closest('div').find('iframe');

            iframe.attr('src',target);
        })

        $(".print-btn").click(function (){
            let btn = $(this);
            let iframe = btn.closest('div').find('iframe');
            iframe.get(0).contentWindow.print();
        })

        $(".select2-account-codes").select2({
            ajax: {
                url: '/dashboard/ajax/account-codes',
                dataType: 'json',
                delay : 250,

                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            placeholder: "Select",
            allowClear : true,
        });

        $(".select2-subsidiary-account-codes").select2({
            ajax: {
                url: function (){
                    let parentAccountCode = $(this)
                        .closest('form')   // 👈 adjust this
                        .find('.select2-account-codes')
                        .val();
                    return '/dashboard/ajax/subsidiary-account-codes?parent_account_code='+parentAccountCode;
                },
                dataType: 'json',
                delay : 250,

                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            placeholder: "Select",
            allowClear : true,
        });
    </script>
@endsection