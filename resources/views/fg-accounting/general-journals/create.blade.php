@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New General Journal</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="add-journal-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>


            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <x-forms.input label="JV No." name="control_no" cols="6"/>
                        <x-forms.input label="Date" name="date" cols="6" type="date"/>
                    </div>
                    <div class="row mt-2 mb-4">
                        <x-forms.textarea label="Explanation" name="remarks" cols="12"/>
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
                url : '{{route("general-journals.store")}}',
                data : $.param(data),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Journal successfully saved.','Success!');
                    $("#entries-table tbody").html('');
                    $(".add-btn").trigger('click');
                    subsidiaryLedgers = {};
                },
                error: function (res) {
                    errored(form,res);
                }
            })


        })



    </script>
@endsection