@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Edit Cash Disbursement Journal</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="edit-journal-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>


            <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <x-forms.input label="CV No." name="control_no" cols="6" :value="$journal ?? null"/>
                            <x-forms.input label="Date" name="date" cols="6" type="date" :value="$journal ?? null"/>
                        </div>
                        <div class="row mt-2">
                            <x-forms.input label="Payee" name="counterparty" cols="12" :value="$journal ?? null"/>
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
                                <th style="width: 40px;">
                                    <button type="button" class="btn btn-secondary btn-sm add-btn" template="#entries-template">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($journal->entries as $entry)

                                <tr id="checks-rand" data-id="{{$entry->id}}">
                                    <td class="align-top">
                                        <x-forms.select :select-only="true"
                                                        :auto-class="true"
                                                        class="select2-ajax-auto-populate"
                                                        label="A"
                                                        name="entries[rand][account_code]"
                                                        cols="12"
                                                        :s2-id="$entry->account_code"
                                                        :s2-text="$entry->chartOfAccount->account_title .' - '.$entry->account_code "
                                                        :s2-url='route("dashboard.ajax.get","account-codes")'
                                        />
                                    </td>

                                    <td class="align-top">
                                        <x-forms.input :input-only="true" :auto-class="true" label="" name="entries[rand][debit]" for="debit" class="text-end autonum autonum-"  cols="12" :value="$entry->debit"/>
                                    </td>

                                    <td class="align-top">
                                        <x-forms.input :input-only="true" :auto-class="true" label="" name="entries[rand][credit]" for="credit" class="text-end autonum autonum-"  cols="12" :value="$entry->credit"/>
                                    </td>

                                    <td class="align-top">
                                        <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>


                            @empty
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th id="total-debit" class="text-end">
                                    {{number_format($journal->entries->sum('debit'),2)}}
                                </th>
                                <th id="total-credit" class="text-end">
                                    {{number_format($journal->entries->sum('credit'),2)}}
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
        </div>

        </x-adminkit.html.card>
    </form>

    @include('fg-accounting.common.t-entries')
@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/journals.js')}}"></script>
    <script type="text/javascript">

        $("#edit-journal-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("cash-disbursements.update",$journal->uuid)}}',
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Journal successfully updated.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>
@endsection