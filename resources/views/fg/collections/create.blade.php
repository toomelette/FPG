@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Collection Receipt</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <form id="add-collection-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit" data-bs-toggle="modal"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row">
                <x-forms.select label="Payment Type" name="payment_type" cols="2" :options="\App\Swep\Helpers\Arrays::paymentTypes()"/>
                <x-forms.input label="Reference No." name="ref_no" cols="2"/>
                <x-forms.input label="Date" name="date" cols="2" type="date"/>
                <x-forms.input label="Payor" name="payor" cols="3"/>
                <x-forms.input label="Address" name="address" cols="3"/>
            </div>
            <div class="row mt-2">
                <x-forms.textarea label="Remarks" name="remarks" cols="4"/>
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

                        </tbody>
                    </table>
                </div>
                <div class="col-md-2">
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Total Amount
                    </p>
                    <div class="row mt-2">
                        <x-forms.input label="Total Check Amount" class="autonum text-end autonum-auto-init-assoc" name="total_check" cols="12" readonly="readonly"/>
                    </div>

                    <div class="row mt-2">
                        <x-forms.input label="Cash Amount" class="autonum-auto-init-assoc text-end compute" name="total_cash" cols="12"/>
                    </div>

                    <div class="row mt-2">
                        <x-forms.input label="Total Payment" class="autonum-auto-init-assoc text-end autonum-auto-init-assoc" name="total_amount" cols="12" readonly="readonly"/>
                    </div>

                    <div class="row mt-2">
                        <x-forms.input label="CWT" class="autonum-auto-init-assoc text-end compute" name="cwt" cols="12"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Total Amount Paid" class="autonum-auto-init-assoc text-end" name="total_paid" cols="12" readonly="readonly"/>
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
            $(".add-btn").trigger('click');
            $("body").on("click",".remove_row_btn",function (){
                compute($("#add-collection-form"))
            });
        })


        $("#add-collection-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("collections.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Liquidation successfully saved.','Success');
                    $("#distribution-table tbody").html('')
                        .ready(function (){
                            $("#distribution-table .add-btn").trigger('click');
                        })
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection