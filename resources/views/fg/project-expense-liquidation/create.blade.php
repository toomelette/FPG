@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Project Expense Liquidation</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <form id="add-project-expense-liquidation-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit" data-bs-toggle="modal"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <div class="row mb-3">
                <x-forms.input label="Control No." name="control_no" cols="2"/>
                <x-forms.input label="Date" name="date" cols="2" type="date"/>
                <x-forms.textarea label="Remarks" name="remarks" cols="6"/>
            </div>
            
            <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Details
            </x-adminkit.html.alert>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm table-bordered" id="details-table">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th style="width: 20%">Debit</th>
                            <th style="width: 20%">Credit</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#details-template">
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
                                <th id="total-debit" class="text-end">0.00</th>
                                <th id="total-credit" class="text-end">0.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <x-adminkit.html.alert type="info" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Projects
            </x-adminkit.html.alert>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm table-bordered" id="projects-table">
                        <thead>
                        <tr>
                            <th style="width: 30%;">Client</th>
                            <th>Sales</th>
                            <th style="width: 20%">Amount</th>
                            <th style="width: 50px">
                                <button type="button" class="btn btn-secondary btn-sm add-btn" template="#projects-template">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th id="total-amount" class="text-end">0.00</th>
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
        $(document).ready(function (){
            $(".add-btn").trigger('click');
        })


        
        $("#add-project-expense-liquidation-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("project-expense-liquidation.store")}}',
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