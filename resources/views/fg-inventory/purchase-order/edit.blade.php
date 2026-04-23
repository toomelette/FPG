@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Edit Purchase Order</x-slot:title>
        <x-slot:subtitle> {{$purchaseOrder->control_no}}</x-slot:subtitle>
    </x-adminkit.html.page-title>

    <form id="edit-purchase-order-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>

            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <x-forms.input label="PO No." name="control_no" cols="6" :value="$purchaseOrder ?? null"/>
                        <x-forms.input label="PO Date." name="date" cols="6" type="date" :value="$purchaseOrder ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Terms" name="terms" cols="6" :value="$purchaseOrder ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Supplier" name="supplier" cols="12" :value="$purchaseOrder ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Acct No." name="account_no" cols="6" :value="$purchaseOrder ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.textarea label="Remarks" name="remarks" cols="12" :value="$purchaseOrder ?? null"/>
                    </div>

                </div>
                <div class="col-md-8">
                    <table class="table table-striped table-sm table-bordered" id="details-table">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th style="width: 15%">Qty</th>
                            <th style="width: 15%">Unit of Meas.</th>
                            <th style="width: 15%">Unit Cost</th>
                            <th style="width: 15%">Total Cost</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#details-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($purchaseOrder->details as $detail)
                            <tr id="details-{{$detail->id}}" data-id="{{$detail->id}}">

                                <td class="align-top">
                                    <x-forms.select :select-only="true" :auto-class="true" class="select2-ajax-auto-populate" :s2-id="$detail->stock_uuid ?? $detail->description" :s2-text="$detail->stock->name" :s2-url='route("dashboard.ajax.get","stocks")' label="A" name="details[{{$detail->id}}][description]" cols="12"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.input type="number" class="compute" step="0.01" :input-only="true" :auto-class="true"  label="Qty" name="details[{{$detail->id}}][qty]" cols="12" :value="$detail->qty"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.select :select-only="true" :auto-class="true"  label="A" :options="\App\Swep\Helpers\Arrays::uoms()" name="details[{{$detail->id}}][uom]" cols="12" :value="$detail->uom"/>
                                </td>

                                <td class="align-top">
                                    <x-forms.input :input-only="true"  :auto-class="true" label="" name="details[{{$detail->id}}][unit_cost]" class="text-end autonum-auto-init-assoc compute" cols="12" :value="$detail->unit_cost"/>
                                </td>
                                <td class="align-top">
                                    <x-forms.input :input-only="true" :auto-class="true" label="" name="details[{{$detail->id}}][amount]" class="text-end " readonly="readonly" cols="12" :value="Helper::toNumber($detail->amount)"/>
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
            </div>

        </x-adminkit.html.card>
    </form>

    @include('fg-inventory.purchase-order.t-details')
@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/purchase-orders.js')}}"></script>
    <script type="text/javascript">
        $("body").on("click",".add-btn",function (){
            let btn = $(this);
            let table = btn.parents('table');
            let templateId = btn.attr('template');
            let rand = makeId(5);
            let template = $(templateId).html().replaceAll('rand',rand);
            table.find('tbody')
                .append(template)
                .ready(function (){
                    autonums[rand] = new AutoNumeric('.autonum-'+rand, autonum_settings_simple);
                    $("#select2-details-"+rand).select2({
                        ajax: {
                            url: '{{route("dashboard.ajax.get","stocks")}}',
                            dataType: 'json',
                            delay : 250,

                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        },
                        placeholder: "Select",
                        allowClear : true,
                    });
                });
        })


        $("#edit-purchase-order-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("purchase-orders.update",$purchaseOrder->uuid)}}';
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('info','Receiving Report successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection