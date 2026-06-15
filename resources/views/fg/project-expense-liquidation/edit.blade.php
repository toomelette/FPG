@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Edit Project Expense Liquidation</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <form id="edit-project-expense-liquidation-form">

        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit" data-bs-toggle="modal"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row mb-3">
                <x-forms.input label="Control No." name="control_no" cols="2" :value="$projectExpenseLiquidation ?? null"/>
                <x-forms.input label="Date" name="date" cols="2" type="date" :value="$projectExpenseLiquidation ?? null"/>
                <x-forms.textarea label="Remarks" name="remarks" cols="6" :value="$projectExpenseLiquidation ?? null"/>
            </div>

            <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Details
            </x-adminkit.html.alert>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm table-bordered" id="details-table">
                        <thead>
                        <tr>
                            <th style="width: 30%;">Client/Sales Invoice</th>
                            <th>Description</th>
                            <th style="width: 15%">Debit</th>
                            <th style="width: 15%">Credit</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#details-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($projectExpenseLiquidation->details as $detail)
                            <tr id="details-{{$detail->id}}" data="{{$detail->id}}">
                                <td>
                                    <x-forms.select :select-only="true" :auto-class="true" class="select2-ajax-auto-populate" id="select-client-{{$detail->id}}" label="A" name="details[{{$detail->id}}][client_uuid]" cols="12" :s2-id="$detail->salesInvoice->client_uuid ?? null" :s2-text="$detail?->salesInvoice?->client?->name.' - '.$detail?->salesInvoice?->client?->account_no" :s2-url="route('dashboard.ajax.get','clients')" />

                                    <x-forms.select :select-only="true" :auto-class="true" class="select2-ajax-auto-populate-pel" label="A" name="details[{{$detail->id}}][sales_invoice_uuid]" cols="12" :s2-id="$detail?->salesInvoice?->uuid" :s2-text="$detail?->salesInvoice?->remarks.' - '.$detail?->salesInvoice?->invoice_no" :s2-url="route('dashboard.ajax.get','invoices-grouped-by-clients')" container-class="mt-2 mb-2"/>

                                </td>
                                <td class="align-top">
                                    <x-forms.select :select-only="true" :auto-class="true" class="select2-ajax-auto-populate" label="A" name="details[{{$detail->id}}][description]" cols="12" :s2-id="$detail->description" :s2-text="$detail->description" :s2-url="route('dashboard.ajax.get','project-expense-liquidation-description')" />
                                </td>
                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true" label="" name="details[{{$detail->id}}][debit]" class="text-end autonum autonum-" cols="12" :value="$detail->debit ?? null"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true" label="" name="details[{{$detail->id}}][credit]" class="text-end autonum autonum-" cols="12" :value="$detail->credit ?? null"/>
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
                            <th colspan="2">Total</th>
                            <th id="total-debit" class="text-end">{{number_format($projectExpenseLiquidation->details->sum('debit'),2)}}</th>
                            <th id="total-credit" class="text-end">{{number_format($projectExpenseLiquidation->details->sum('credit'),2)}}</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </x-adminkit.html.card>



    </form>




    @include('fg.project-expense-liquidation.t-details')
    @include('fg.project-expense-liquidation.t-projects')
@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/project-expense-liquidation.js')}}"></script>

    <script type="text/javascript">
        $("#select2-project").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","invoices-grouped-by-clients")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });


        $("#edit-project-expense-liquidation-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("project-expense-liquidation.update", $projectExpenseLiquidation->uuid)}}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('success','Liquidation successfully saved','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $(".select2-ajax-auto-populate-pel").each(function (){
            let $select = $(this);
            let url = $select.data('s2-url');
            let id = $select.data('s2-id');
            let text = $select.data('s2-text');
            let trId = '#'+$select.closest('tr').attr('id');
            let trData = $select.closest('tr').attr('data');

            $select.select2({
                ajax: {
                    url: function (params){
                        let client = $(trId+" #select-client-"+trData).val();
                        return '{{route("dashboard.ajax.get","invoices-grouped-by-clients")}}?client='+client;

                    },
                    dataType: 'json',
                    delay: 250,
                },

                placeholder: "Select",
                allowClear : true,
                templateResult: function (data) {
                    return data.text + (typeof data.html !== 'undefined' ? data.html  : '');
                },
                /*
                templateSelection: function (data) {
                    return data.text + data.html;
                },
                */
                escapeMarkup: function (markup) {
                    return markup; // allow HTML
                }
            });

            if (id && text) {
                let option = new Option(text, id, true, true);
                $select.append(option).trigger('change');
            }
        })

    </script>
@endsection