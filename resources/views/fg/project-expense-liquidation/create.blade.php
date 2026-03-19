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
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <x-forms.input label="Control No." name="control_no" cols="6"/>
                        <x-forms.input label="Date" name="date" cols="6" type="date"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.select label="Project" name="invoice_uuid" cols="12" :options="[]" id="select2-project"/>
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
                            <th style="width: 200px">Debit</th>
                            <th style="width: 200px">Credit</th>
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


    <table class="hide-this">
        <tbody id="details-template">
        <tr id="details-rand">
            <td class="align-top">
                <x-forms.select :select-only="true" :auto-class="true" id="select2-details-rand" label="A" name="details[rand][description]" cols="12"/>
            </td>
            <td class="align-top">
                <x-forms.input :input-only="true" :auto-class="true" label="" name="details[rand][debit]" class="text-end autonum-rand" cols="12"/>
            </td>
            <td class="align-top">
                <x-forms.input :input-only="true" :auto-class="true" label="" name="details[rand][credit]" class="text-end autonum-rand" cols="12"/>
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

        $("body").on("click",".add-btn",function (){
            let btn = $(this);
            let table = btn.parents('table');
            let templateId = btn.attr('template');
            let rand = makeId(5);
            let template = $(templateId).html().replaceAll('rand',rand);
            table.find('tbody')
                .append(template)
                .ready(function (){
                    initializeAutonumByClass('.autonum-'+rand);
                    $("#select2-details-"+rand).select2({
                        ajax: {
                            url: '{{route("dashboard.ajax.get","project-expense-liquidation-description")}}',
                            dataType: 'json',
                            delay : 250,

                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        },
                        placeholder: "Select",
                        allowClear : true,
                    });
                });
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