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
                        Collection Summary
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="cash-receipts-register" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Collection Summary</h5>
                        </div>
                        <div class="card-body pt-0">
                            <form class="report-form" target="{{route('collections.reports')}}?generate&report_type=collection-summary">
                                <div class="row mb-2">
                                    <x-forms.select :options="\App\Swep\Helpers\Arrays::paymentTypes()" label="Payment Type" name="payment_type" cols="2" />
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
            let iframe = form.closest('div').find('iframe');

            let separator = route.includes('?') ? '&' : '?';
            let target = route + separator + params;

            iframe.attr('src', target);
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