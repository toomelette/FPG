@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Products</x-slot:title>
    </x-adminkit.html.page-title>


    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <div class="btn-group float-end">
                @canAccess('stocks.store')
                <a href="{{route('stocks.index')}}?maintenance" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa fa-gear"></i> Categories/UOM</a>
                <button class="btn btn-sm btn-primary" data-bs-target="#add-stock-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
                @endcanAccess
            </div>
        </x-slot:title>
        <table class="table table-bordered table-striped table-hover table-sm" id="stocks-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Name</th>
                <th>Description</th>
                <th>Unit</th>
                <th>Bar Code</th>
                <th>Category</th>
                <th>Balance</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-stock-modal" size="" form-id="add-stock-form">
        <x-slot:title>New Product</x-slot:title>
        <div class="row">
            <x-forms.input label="Product Name" name="name" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Description" name="description" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.select label="Unit" name="uom" cols="4" :options="\App\Swep\Helpers\Arrays::uoms()"/>
            <x-forms.select label="Category" name="category" cols="4" :options="\App\Swep\Helpers\Arrays::productCategories()"/>
            <x-forms.input label="Bar Code" name="bar_code" cols="4"/>
        </div>
        <x-adminkit.html.alert type="info mt-4 mb-2" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
            Beginning Balance
        </x-adminkit.html.alert>

        <div class="row">
            <x-forms.input label="Date" name="beg_bal_date" cols="4" type="date"/>
            <x-forms.input label="Qty" name="beg_bal_qty" cols="4" type="number" step="0.01" />
        </div>

        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    
    <x-adminkit.html.modal id="edit-stock-modal" size=""/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        stocksTbl = $("#stocks-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{Request::getUri()}}',
            columns : [
                { data : "name" },
                { data : "description" },
                { data : "uom" },
                { data : "bar_code" },
                { data : "category" },
                { data : "ending_balance"},
                { data : "action" },
            ],
            buttons : [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs :[
                {
                    targets: '_all',
                    class : 'align-top'
                },
                {
                    targets : 5,
                    render: function (data,type,row,meta) {
                        if(data == 0){
                            return '-';
                        }
                        let val1 = parseFloat(data);
                        let val2 = parseFloat(row.beg_bal_qty);
                        return val1+val2;
                    },
                    class : 'text-center',
                },
                {
                    targets : 6,
                    orderable : false,
                    class : ''
                },
                {
                    targets : 5,
                    orderable : false,
                    searchable : false,
                    class : ''
                },
            ],
            order:[[0,'asc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        stocksTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#add-stock-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("stocks.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.uuid;
                    stocksTbl.draw(false);
                    succeed(form,true,true);
                    toast('success','Product successfully added.','Success');

                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })


        $("body").on("click",".edit-stock-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("stocks.edit","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

    </script>
@endsection