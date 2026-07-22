@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Delivery Receipt</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="edit-delivery-receipt-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row mb-2">


                <div class="col-md-3">
                    <div class="row mb-2">
                        <x-forms.select label="DR Type" name="type" cols="6" :options="\App\Swep\Helpers\Arrays::deliveryTypes()" :value="$dr ?? null"/>
                        <x-forms.input label="DR No." name="control_no" cols="6" :value="$dr ?? null"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Date" name="date" cols="12" type="date" :value="$dr ?? null"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.select label="Project" name="invoice_uuid" cols="12" :options="[]" id="select2-project" :value="$dr ?? null" select2-preselected="{{$dr?->invoice?->remarks.' - '.$dr?->invoice?->invoice_no}}"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Terms" name="terms" cols="12" :value="$dr ?? null"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.textarea label="Remarks" name="remarks" cols="12"  :value="$dr ?? null"/>
                    </div>
                </div>



                <div class="col-md-9">
                    <table class="table table-striped table-sm table-bordered" id="details-table">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th style="width: 100px">Qty</th>
                            <th style="width: 170px">Unit of Meas.</th>
                            <th style="width: 170px">Unit Cost</th>
                            <th style="width: 170px">Total Cost</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#details-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dr->details as $detail)
                            <tr id="details-rand" data-id="{{$detail->id}}">
                                <td class="align-top">
                                    <x-forms.select :select-only="true" :auto-class="true" class="select2-ajax-auto-populate allow-new-items"  label="A" name="details[{{$detail->id}}][description]" cols="12" :s2-id="$detail->stock_uuid ?? $detail->description" :s2-text="$detail->description" :s2-url='route("dashboard.ajax.get","stocks")'/>
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
                                    <x-forms.input :input-only="true" :auto-class="true" label="" name="details[{{$detail->id}}][amount]" class="text-end autonum-auto-init-assoc" readonly="readonly" cols="12" :value="$detail->amount"/>
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
                            <td colspan="4"></td>
                            <td class="align-top text-strong text-end">
                                <span id="grandTotal">{{number_format($dr->details_sum_amount,2)}}</span>
                            </td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </x-adminkit.html.card>
    </form>


    <table class="hide-this">
        <tbody id="details-template">
        <tr id="details-rand" data-id="rand">
            <td class="align-top">
                <x-forms.select :select-only="true" :auto-class="true" id="select2-details-rand" label="A" name="details[rand][description]" cols="12"/>
            </td>
            <td class="align-top">
                <x-forms.input type="number" class="compute" step="0.01" :input-only="true" :auto-class="true"  label="Qty" name="details[rand][qty]" cols="12"/>
            </td>
            <td class="align-top">
                <x-forms.select :select-only="true" :auto-class="true"  label="A" :options="\App\Swep\Helpers\Arrays::uoms()" name="details[rand][uom]" cols="12"/>
            </td>

            <td class="align-top">
                <x-forms.input :input-only="true"  :auto-class="true" label="" name="details[rand][unit_cost]" class="text-end autonum-rand compute" cols="12"/>
            </td>
            <td class="align-top">
                <x-forms.input :input-only="true" :auto-class="true" label="" name="details[rand][amount]" class="text-end" readonly="readonly" cols="12"/>
            </td>
            <td class="align-top">
                <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
            </td>
        </tr>
        </tbody>
    </table>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/delivery-receipt.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            autonumGlobalInstances['totalAmountDue'] = 0;
            $("#select2-project").select2({
                ajax: {
                    url: '{{route("dashboard.ajax.get","invoices-grouped-by-clients")}}',
                    dataType: 'json',
                    delay : 250,
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
            });
        })
        $("body").on("change keyup",'.compute',function(){
            compute($(this).closest('tr'));
        });
        $("body").on("click",".remove_row_btn",function (){
            computeTable($("#details-table"));
        })

        $("body").on("click",".add-btn",function (){
            let btn = $(this);
            let table = btn.parents('table');
            let templateId = btn.attr('template');
            let rand = makeId(5);
            let template = $(templateId).html().replaceAll('rand',rand);
            table.find('tbody')
                .append(template)
                .ready(function (){
                    autonumGlobalInstances[rand] = new AutoNumeric('.autonum-'+rand, autonum_settings_simple);
                    $("#select2-details-"+rand).select2({
                        ajax: {
                            url: '{{route("dashboard.ajax.get","stocks")}}',
                            dataType: 'json',
                            delay : 250,

                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        },
                        placeholder: "Select",
                        allowClear : true,
                        tags: true,

                        createTag: function (params) {
                            var term = $.trim(params.term);

                            if (term === '') {
                                return null;
                            }

                            return {
                                id: term,
                                text: term,
                                newTag: true
                            };
                        },
                        templateResult: function (data) {
                            if (data.newTag) {
                                return $('<span>' + data.text + ' <em style="color:green;" class="small">- NON STOCK</em></span>');
                            }
                            return data.text;
                        },
                    });
                });
        })

        $("#edit-delivery-receipt-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("delivery-receipts.update",$dr->uuid)}}',
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('info','Delivery Receipt successfully saved.','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>
@endsection