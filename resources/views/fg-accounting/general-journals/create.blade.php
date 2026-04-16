@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New General Journal</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="add-journal-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>


            <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <x-forms.input label="JV No." name="control_no" cols="6"/>
                            <x-forms.input label="Date" name="date" cols="6" type="date"/>
                        </div>
                        <div class="row mt-2 mb-4">
                            <x-forms.textarea label="Explanation" name="remarks" cols="12"/>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <x-adminkit.html.alert type="info" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                            JOURNAL ENTRIES
                        </x-adminkit.html.alert>

                        <table class="table table-striped table-bordered table-sm" id="entries-table">
                            <thead>
                            <tr>
                                <th>Account Code/Title</th>
                                <th style="width: 20%">Debit</th>
                                <th style="width: 20%">Credit</th>
                                <th style="width: 40px;">
                                    <button type="button" class="btn btn-secondary btn-sm add-btn" template="#entries-template">
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
                            </tr>
                            </tfoot>
                        </table>
                    </div>
        </div>

        </x-adminkit.html.card>
    </form>

    @include('fg-accounting.common.t-entries')
@endsection


@section('modals')

@endsection

@section('scripts')
    <script src="{{asset('js/fg/journals.js')}}"></script>
    <script type="text/javascript">


        $(document).ready(function (){
            $(".add-btn").trigger('click');
        })

        $("#add-journal-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("general-journals.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Journal successfully saved.','Success!');
                    $("#entries-table tbody").html('');
                    $(".add-btn").trigger('click');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>
@endsection