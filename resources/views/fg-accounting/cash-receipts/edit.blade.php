@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Edit Cash Receipt Journal</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="edit-journal-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <x-forms.select :options="\App\Swep\Helpers\Arrays::paymentTypes()" label="Ref Coll. Type" name="ref_payment_type" id="ref_payment_type" cols="6"/>
                        <x-forms.select label="OR No." name="control_no" id="or_no" cols="6"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Date" name="date" cols="6" type="date" :value="$journal ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Payor" name="counterparty" id="counterparty" cols="12" readonly :value="$journal ?? null"/>
                        <x-forms.input label="Client UUID" name="client_uuid" id="client_uuid" container-class="hide-this" cols="12" readonly :value="$journal ?? null"/>
                        <x-forms.input label="Collection UUID" name="collection_uuid" id="collection_uuid" container-class="hide-this" cols="12" readonly :value="$journal ?? null"/>


                        <a href="#"><span class="warning-message small text-info" id="counterparty-info" style="display: none" data-bs-toggle="modal" data-bs-target="#counterparty-info-modal"> Show all journals with this payee.</span></a>
                    </div>
                    <div class="row mt-2 mb-4">
                        <x-forms.textarea label="Explanation" name="remarks" cols="12" :value="$journal ?? null"/>
                    </div>
                    <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        Bank Details
                    </x-adminkit.html.alert>
                    <div class="row mt-2">
                        <x-forms.input label="Bank" name="bank" cols="6" :value="$journal ?? null"/>
                        <x-forms.input label="Check No." name="check_no" cols="6" :value="$journal ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Check Amount" name="check_amount" cols="6" class="autonum text-end" :value="$journal ?? null"/>
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
                        @forelse($journal->entries as $entry)

                            <tr id="journal-entries-{{$entry->uuid}}" data-id="{{$entry->uuid}}">
                                <td class="align-top">
                                    <x-forms.select :select-only="true"
                                                    :auto-class="true"
                                                    class="select2-ajax-auto-populate"
                                                    label="A"
                                                    name="entries[{{$entry->uuid}}][account_code]"
                                                    cols="12"
                                                    :s2-id="$entry->account_code"
                                                    :s2-text="$entry->chartOfAccount->account_title .' - '.$entry->account_code "
                                                    :s2-url='route("dashboard.ajax.get","account-codes")'
                                    />
                                </td>

                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true" label="" name="entries[{{$entry->uuid}}][debit]" for="debit" class="text-end autonum autonum-"  cols="12" :value="$entry->debit"/>
                                </td>

                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true" label="" name="entries[{{$entry->uuid}}][credit]" for="credit" class="text-end autonum autonum-"  cols="12" :value="$entry->credit"/>
                                </td>
                                <td class="align-top">
                                    <div class="btn-group float-end">
                                        <button type="button" class="btn btn-outline-secondary btn-sm subsidiary-ledger-btn" data-bs-target="#subsidiary-ledgers-modal" data-bs-toggle="modal">
                                            <span class="counter">
                                                {{$entry->subsidiaries->count() > 0 ? $entry->subsidiaries->count() : ''}}
                                            </span>
                                            <i class="fa fa-list"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger remove-row-btn btn-sm"><i class="fa fa-times"></i></button>
                                    </div>
                                </td>
                            </tr>


                        @empty
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th class="text-end total-debit">
                                {{number_format($journal->entries->sum('debit'),2)}}
                            </th>
                            <th class="text-end total-credit">
                                {{number_format($journal->entries->sum('credit'),2)}}
                            </th>
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

@php

    $subsidiaryLedgers = $journal->entries->mapWithKeys(function ($entry){
        $sls = [];
        foreach ($entry->subsidiaries as $subsidiary){

            $sls[] = [
                'account_code' => $subsidiary->account_code,
                'account_text' => $subsidiary?->subsidiaryAccount?->account_title.' - '.$subsidiary->account_code,
                'debit' => $subsidiary->debit * 1,
                'credit' => $subsidiary->credit * 1,
                'id' => $subsidiary->id,
            ];
        }

        return [
            $entry->uuid => $sls,
        ];
    });

@endphp
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
    <x-adminkit.html.modal id="counterparty-info-modal" size="lg"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let subsidiaryLedgers = {!! json_encode($subsidiaryLedgers) !!};
    </script>
    <script src="{{asset('js/fg/journals.js')}}?rand={{Str::random(3)}}"></script>
    <script type="text/javascript">
        let orNo = '{{$journal?->collection?->ref_no}} - {{Helper::getInitials($journal?->collection?->payment_type)}}';
        let option = new Option(orNo, orNo, true, true);
        $('#or_no').append(option).trigger('change');

        $("#edit-journal-form").submit(function (e) {
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
                url : '{{route("cash-receipts.update",$journal->uuid)}}',
                data : data,
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('info','Journal successfully updated.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })


    </script>
@endsection