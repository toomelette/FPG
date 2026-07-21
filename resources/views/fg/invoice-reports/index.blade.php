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
                        Summary
                    </a>
{{--                    <a class="list-group-item list-group-item-action list-group-primary" data-bs-toggle="list" href="#cash-disbursements-register" role="tab" aria-selected="false" tabindex="-1">--}}
{{--                        Cash Disbursements Register--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="cash-receipts-register" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Summary</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('invoice-reports.print','sales-invoice-summary')}}">
                                <div class="row mb-2">
                                    <x-forms.input label="Date From" name="date_from" cols="2" type="date"/>
                                    <x-forms.input label="Date To" name="date_to" cols="2" type="date"/>
                                    <x-forms.select label="Invoice Type" name="ref_book" cols="2" :options="\App\Swep\Helpers\Arrays::invoiceTypes()"/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Generate Report</button>
                                <hr>
                            </form>
                            <div class="btn-group float-end">
                                <a type="button" target="_blank" class="btn btn-sm btn-outline-secondary mb-2 excel-btn hide-this"><i class="fa fa-file-excel"></i> Excel</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-2 print-btn"><i class="fa fa-print"></i> Print</button>
                            </div>
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
    <script type="text/javascript" src="{{asset('js/fg/reports.js')}}"></script>
    <script type="text/javascript">


    </script>
@endsection