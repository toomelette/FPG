@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Cash Disbursement Journal</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="add-journal-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>


            <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <x-forms.input label="CV No." name="control_no" cols="6"/>
                            <x-forms.input label="Date" name="date" cols="6" type="date"/>
                        </div>
                        <div class="row mt-2">
                            <x-forms.input label="Payee" name="counterparty" cols="12"/>
                        </div>
                        <div class="row mt-2 mb-4">
                            <x-forms.textarea label="Explanation" name="remarks" cols="12"/>
                        </div>
                        <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                            Bank Details
                        </x-adminkit.html.alert>
                        <div class="row mt-2">
                            <x-forms.input label="Bank" name="bank" cols="6"/>
                            <x-forms.input label="Check No." name="check_no" cols="6"/>
                        </div>
                        <div class="row mt-2">
                            <x-forms.input label="Check Amount" name="check_amount" cols="6" class="autonum text-end"/>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <x-adminkit.html.alert type="info" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                            JOURNAL ENTRIES
                        </x-adminkit.html.alert>

                        <table class="table table-striped table-bordered table-sm" id="entries-table">
                            <thead>
                            <tr>
                                <th>Account Code/Title</th>
                                <th style="width: 20%">Debit</th>
                                <th style="width: 20%">Credit</th>
                                <th style="width: 90px;">
                                    <button type="button" class="btn btn-secondary btn-sm add-btn float-end" template="#entries-template">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-end total-debit">0.00</th>
                                <th class="text-end total-credit">0.00</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
        </div>

        </x-adminkit.html.card>

    </form>

    @include('fg-accounting.cash-disbursements.t-entries')
    @include('fg-accounting.cash-disbursements.t-subsidiary-ledger-entries')
@endsection


@section('modals')
<x-adminkit.html.modal-template id="subsidiary-ledgers-modal" size="lg" form-id="subsidiary-ledger-form" :static="true">
    <x-slot:title><span id="title">Account</span></x-slot:title>
    <table class="table table-striped table-bordered table-sm" id="subsidiary-ledger-table">
        <thead>
        <tr>
            <th>Account Code/Title</th>
            <th style="width: 20%">Debit</th>
            <th style="width: 20%">Credit</th>
            <th style="width: 40px;">
                <button type="button" class="btn btn-secondary btn-sm add-sl-btn" template="#subsidiary-ledger-template">
                    <i class="fa fa-plus"></i>
                </button>
            </th>
        </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        <tr>
            <th>Total</th>
            <th class="total-debit text-end">0.00</th>
            <th class="total-credit text-end">0.00</th>
            <th></th>
        </tr>
        </tfoot>

    </table>
    <x-slot:footer>
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
    </x-slot:footer>
</x-adminkit.html.modal-template>

@endsection

@section('scripts')
    <script type="text/javascript">
        let subsidiaryLedgers = {};
    </script>
    <script src="{{asset('js/fg/journals.js')}}?rand={{Str::random(3)}}"></script>
    <script type="text/javascript">

        $(document).ready(function (){
            $(".add-btn").trigger('click');
        })

        $("#add-journal-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            data = form.serializeArray();


            //push subsi
            data.push({
                name: 'subsidiary_ledgers',
                value : JSON.stringify(subsidiaryLedgers),
            })

            loading_btn(form);

            $.ajax({
               url : '{{route("cash-disbursements.store")}}',
                data : $.param(data),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Journal successfully saved.','Success!');
                    compute($("#entries-table"));
                    $("#entries-table tbody").html('');
                    $(".add-btn").trigger('click');
                    subsidiaryLedgers = {};

                    //choose what to do:
                    Swal.fire({
                        title: 'What to do next?',
                        showConfirmButton: false,
                        html: `
                            <button id="btn1" class="btn btn-lg btn-primary"><i class="fa fa-print"></i> Print Voucher</button>
                            <button id="btn2" class="btn btn-lg btn-success" data-bs-toggle="modal" data-bs-target="#print-check-modal"><i class="fa fa-print"></i> Print Check</button>
                            <button id="btn3" class="btn btn-lg btn-outline-secondary"><i class="fa fa-plus"></i> New Journal</button>
                          `,
                        didOpen: () => {
                            $("#btn1").click(function (){
                                printDialog(res.href+'?print-voucher');
                            });
                            $("#btn2").click(function (){
                                printDialog(res.href+'?print-check');

                            });
                            $("#btn3").click(function (){
                                Swal.close('opt3');
                            });
                        }
                    }).then((result) => {
                        console.log(result.dismiss || result.value);
                    });

                },
                error: function (res) {
                    errored(form,res);
                }
            })


        })



    </script>
@endsection