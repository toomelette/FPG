@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Delivery Receipts</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="add-delivery-receipt-preparation-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row mb-2">
                <div class="col-md-3">
                    <div class="row mb-2">
                        <x-forms.select label="DR Type" name="type" cols="6" :options="\App\Swep\Helpers\Arrays::deliveryTypes()"/>
                        <x-forms.input label="DR No." name="control_no" cols="6"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Date" name="date" cols="12" type="date"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.select label="Project/Invoice" name="invoice_uuid" cols="12" :options="[]" id="select2-project"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Terms" name="terms" cols="12"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.textarea label="Remarks" name="remarks" cols="12" />
                    </div>
                </div>
                <div class="col-md-9">
                    <table class="table table-striped table-sm table-bordered" id="details-table">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th style="width: 100px">Qty</th>
                            <th style="width: 170px">Unit of Meas.</th>
                            <th style="width: 170px" class="hide-this">Unit Cost</th>
                            <th style="width: 170px" class="hide-this">Total Cost</th>
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


    @include('fg.delivery-receipts.t-details')
@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/delivery-receipt.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function (){
            $(".add-btn").trigger('click');
            autonumGlobalInstances['totalAmountDue'] = 0;
            $("#select2-project").select2({
                ajax: {
                    url: '{{route("dashboard.ajax.get","invoices-grouped-by-clients")}}',
                    dataType: 'json',
                    delay : 250,
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: "Select",
                allowClear: true,
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
                        return $('<span>' + data.text + ' <em style="color:green;" class="small">- User Input</em></span>');
                    }
                    return data.text;
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
                        allowClear: true,
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

        $("#add-delivery-receipt-preparation-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("delivery-receipts.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Delivery receipt successfully saved.','Success');
                    $("#grandTotal").html('0.00');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>
@endsection