@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Purchase Order</x-slot:title>
    </x-adminkit.html.page-title>

    <form id="add-purchase-order-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>

            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <x-forms.input label="PO No." name="control_no" cols="6"/>
                        <x-forms.input label="PO Date." name="date" cols="6" type="date"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Terms" name="terms" cols="6"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Supplier" name="supplier" cols="12"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Address" name="address" cols="12"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Acct No." name="account_no" cols="6"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.textarea label="Remarks" name="remarks" cols="12"/>
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

        $(document).ready(function (){
            $(".add-btn").trigger('click');
        });
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


        $("#add-purchase-order-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("purchase-orders.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#details-table tbody").html('');
                    $(".add-btn").trigger('click');
                    succeed(form,true,true);
                    toast('success','Receiving Report successfully saved.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection