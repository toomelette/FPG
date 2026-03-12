@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Collections</x-slot:title>
        <x-slot:subtitle>Edit</x-slot:subtitle>
    </x-adminkit.html.page-title>

    <form id="edit-collection-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit" data-bs-toggle="modal"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row">
                <x-forms.select label="Payment Type" name="payment_type" cols="2" :options="\App\Swep\Helpers\Arrays::paymentTypes()" :value="$collection ?? null"/>
                <x-forms.input label="Reference No." name="ref_no" cols="2" :value="$collection ?? null"/>
                <x-forms.input label="Date" name="date" cols="2" type="date" :value="$collection ?? null"/>
                <x-forms.input label="Payor" name="payor" cols="3" :value="$collection ?? null"/>
                <x-forms.input label="Address" name="address" cols="3" :value="$collection ?? null"/>
            </div>
            <div class="row mt-2">
                <x-forms.textarea label="Remarks" name="remarks" cols="4" :value="$collection ?? null"/>
            </div>
            <div class="row mt-2">
                <div class="col-md-5">
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Distribution of Payment
                    </p>
                    <table class="table table-striped table-sm table-bordered" id="distribution-table">
                        <thead>
                        <tr>
                            <th style="width: 200px">Ref Invoice</th>
                            <th style="width: 200px">Invoice No</th>
                            <th style="width: 200px">Amount</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#distribution-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($collection->distributions as $distribution)
                            <tr id="distribution-{{$distribution->id}}" data-id="{{$distribution->id}}">
                                <td class="align-top">
                                    <x-forms.select :select-only="true" :auto-class="true" label="" name="distributions[{{$distribution->id}}][ref_invoice]" :options="\App\Swep\Helpers\Arrays::invoiceTypes()" cols="12" :value="$distribution->ref_invoice ?? null"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.input label="Invoice No." :auto-class="true" name="distributions[{{$distribution->id}}][invoice_no]" cols="12" :input-only="true" :value="$distribution->invoice_no ?? null"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true"  label="Amount" data-autonum-key="{{$distribution->id}}" class="autonum-auto-init-assoc text-end compute" name="distributions[{{$distribution->id}}][amount]" cols="12" :value="$distribution->amount ?? null"/>
                                </td>
                                <td class="align-top">
                                    <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="col-md-5">
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Check Details
                    </p>
                    <table class="table table-striped table-sm table-bordered" id="checks-table">
                        <thead>
                        <tr>
                            <th style="">Bank</th>
                            <th style="width: 150px">Check No.</th>
                            <th style="width: 150px">Amount</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#checks-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($collection->checks as $check)
                            <tr id="checks-{{$check->id}}" data-id="{{$check->id}}">
                                <td class="align-top">
                                    <x-forms.select :select-only="true"
                                                    :auto-class="true"
                                                    label=""
                                                    class="select2-ajax-auto-populate"
                                                    name="checks[{{$check->id}}][bank]"
                                                    :options="[]" cols="12"
                                                    :value="$check->bank"
                                                    :s2-id="$check->bank"
                                                    :s2-text="$check->bank"
                                                    :s2-url="route('dashboard.ajax.get','banks')"
                                    />
                                </td>
                                <td class="align-top">
                                    <x-forms.input label="Invoice No." :auto-class="true" name="checks[{{$check->id}}][check_no]" cols="12" :input-only="true" :value="$check->check_no"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true"  label="Amount" data-autonum-key="check-{{$check->id}}" class="autonum-auto-init-assoc text-end compute" name="checks[{{$check->id}}][amount]" cols="12" :value="$check->amount"/>
                                </td>
                                <td class="align-top">
                                    <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2">
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Total Amount
                    </p>
                    <div class="row mt-2">
                        <x-forms.input label="Total Check Amount" class="autonum text-end autonum-auto-init-assoc" name="total_check" cols="12" readonly="readonly" :value="$collection ?? null"/>
                    </div>

                    <div class="row mt-2">
                        <x-forms.input label="Cash Amount" class="autonum-auto-init-assoc text-end compute" name="total_cash" cols="12" :value="$collection ?? null"/>
                    </div>

                    <div class="row mt-2">
                        <x-forms.input label="Total Payment" class="autonum-auto-init-assoc text-end autonum-auto-init-assoc" name="total_amount" cols="12" readonly="readonly" :value="$collection ?? null"/>
                    </div>

                    <div class="row mt-2">
                        <x-forms.input label="CWT" class="autonum-auto-init-assoc text-end compute" name="cwt" cols="12" :value="$collection ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Total Amount Paid" class="autonum-auto-init-assoc text-end" name="total_paid" cols="12" readonly="readonly" :value="$collection ?? null"/>
                    </div>
                </div>
            </div>

        </x-adminkit.html.card>
    </form>

    @include('fg.collections.t-distribution')
    @include('fg.collections.t-checks')

@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/collections.js')}}?{{randString()}}"></script>
    <script type="text/javascript">
        $(document).ready(function (){
            $("body").on("click",".remove_row_btn",function (){
                compute($("#edit-collection-form"))
            });
        })

        $("#edit-collection-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("collections.update", $collection->uuid)}}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('success','Collection successfully updated.','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>
@endsection