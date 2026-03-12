@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Sales Invoice</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <form id="add-sales-invoice-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit" data-bs-toggle="modal"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row">
                <x-forms.input label="Invoice No." name="control_no" cols="2"/>
                <x-forms.input label="Date" name="date" cols="2" type="date"/>
                <x-forms.select label="Project" name="project_uuid" cols="8" :options="[]" id="select2-project"/>
            </div>
            <div class="row mt-2">
                <x-forms.input label="Terms" name="terms" cols="2" />
                <x-forms.textarea label="Remarks" name="remarks" cols="4"/>
            </div>
            <div class="row mt-2">
                <div class="col-md-10">
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Details
                    </p>
                    <table class="table table-striped table-sm table-bordered" id="details-table">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th style="width: 200px">Qty</th>
                            <th style="width: 200px">Unit of Meas.</th>
                            <th style="width: 200px">Unit Cost</th>
                            <th style="width: 200px">Total Cost</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#details-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-2">
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Total Amount
                    </p>
                    <div class="row mt-2">
                        <x-forms.input label="Tax Base" class="autonum text-end" name="tax_base" cols="12"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="VAT" class="autonum text-end" name="vat" cols="12"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Total Amount Due" class="autonum-total-amount-due text-end" name="total_amount_due" cols="12"/>
                    </div>
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
    <script src="{{asset('js/fg/sales-invoice.js')}}"></script>
    <script type="text/javascript">

        $("#select2-project").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","projects-grouped-by-clients")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });
        $(document).ready(function (){
            $(".add-btn").trigger('click');
            autonums['totalAmountDue'] = new AutoNumeric('.autonum-total-amount-due',autonum_settings_simple);
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
        
        $("#add-sales-invoice-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("sales-invoice.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Liquidation successfully saved.','Success');
                    $("#details-table tbody").html('')
                        .ready(function (){
                            $("#details-table .add-btn").trigger('click');
                        })
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection