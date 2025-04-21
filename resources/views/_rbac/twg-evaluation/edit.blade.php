@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Edit Evaluation</x-slot:title>
        <x-slot:subtitle> AQ# {{$eval->aq_no}} </x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>

    <form id="edit-evaluation-form">
        <x-adminkit.html.card header-class="pb-1 pt-3">
            <x-slot:title>
                <div class="btn-group float-end">
                    <button type="button" class="btn btn-secondary btn-sm" id="print-btn"><i class="fa fa-print"></i> Print</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Save</button>
                </div>

            </x-slot:title>
            <div class="row">
                <x-forms.input label="Item/s" name="concat_items" cols="5" :value="$eval ?? null"/>
                <x-forms.input label="Approved Budget" name="abc" cols="2" :value="$eval ?? null"/>
                <x-forms.select label="Mode of Proc." name="mode_of_procurement" cols="2" :value="$eval ?? null" :options="\App\Swep\Helpers\Arrays::modesOfProcurement()"/>
            </div>
            <div class="row mt-2">
                <x-forms.input label="Winning Bidder" name="winning_supplier" cols="5" :value="$eval ?? null"/>
                <x-forms.input label="Bid Price" name="bid_price" cols="3" :value="$eval ?? null"/>
            </div>
            @php
                $groupedBySupplier = $eval->offers->groupBy('supplier')->mapWithKeys(function ($data){
                    return [
                        $data->first()->supplier_slug => $data->first()->relSupplier,
                    ];
                });
                $groupedByItems = $eval->offers->groupBy('item_slug');

            @endphp
            <table class="table table-sm table-bordered mt-3" style="font-size: 12px">
                <thead>
                <tr>
                    <th class="text-center">Item</th>
                    <th class="text-center" style="width: 3%">Qty</th>
                    @forelse($groupedBySupplier as $supplier)
                        <th colspan="2" class="text-center" style="width: {{80/$groupedBySupplier->count()}}%; vertical-align: top" >
                            <label class="form-check">
                                <input class="form-check-input radio-supplier" type="radio" value="{{$supplier->slug}}" label="{{$supplier->name}}" name="winning_supplier_slug" {{$supplier->slug == $eval->winning_supplier_slug ? 'checked' : ''}}>
                                <span class="form-check-label">
                                 {{$supplier->name}}
                            </span>
                            </label>
                        </th>
                    @empty
                    @endforelse
                </tr>
                </thead>
                <tbody>

                @forelse($groupedByItems as $items)
                    @php
                        $item = $items->first();
                    @endphp
                    <tr>
                        <td>{{$item->item}}</td>
                        <td class="text-center">{{$item->qty}}</td>
                        @forelse($groupedBySupplier as $supplier)
                            @php
                                $amount = $items->where('supplier_slug',$supplier->slug)->first()->amount
                            @endphp
                            <td class="text-center">{{$items->where('supplier_slug',$supplier->slug)->first()->offer}}</td>
                            <td class="text-end {{$amount == null ? 'bg-warning' : ''}}">{{Helper::toNumber($amount)}}</td>
                        @empty
                        @endforelse
                    </tr>
                @empty
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td></td>
                    @php
                        $supplierRanks = null;
                    @endphp
                    @forelse($groupedBySupplier as $supplier)
                        <th></th>
                        <th class="text-end">{{Helper::toNumber($eval->offers->where('supplier_slug',$supplier->slug)->sum('total_amount_per_item'))}}</th>
                    @empty
                    @endforelse

                </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="col-md-6">
                    Summary:
                    <table class="table table-bordered table-sm">
                        <tbody>
                        @php
                            $supplierRanks = $groupedBySupplier->sortBy(function ($data) use($eval){
                                    return $eval->offers->where('supplier_slug',$data->slug)->sum('amount');
                                })
                        @endphp
                        @forelse($supplierRanks as $supplierRank)
                            <tr>
                                <td>{{$supplierRank->name}}</td>
                                <td for="{{$supplierRank->name}}" class="text-end text-strong {{$eval->offers->where('supplier_slug',$supplierRank->slug)->where('amount',null)->count() > 0 ? 'text-danger' : ''}}">
                                    {{Helper::toNumber($eval->offers->where('supplier_slug',$supplierRank->slug)->sum('total_amount_per_item'))}}
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <x-forms.input label="Note" name="note" cols="12" :value="$eval ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Justification" name="justification" cols="12" :value="$eval ?? null"/>
                    </div>
                    <div class="row mt-2">
                        <x-forms.input label="Recommending Approval" name="recommending_approval" cols="12" :value="Auth::user()->employee->full['FMiLE']"/>
                    </div>
                </div>
            </div>
        </x-adminkit.html.card>
    </form>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-evaluation-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.rbac_evaluation.update",$eval->slug)}}';
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
                    toast('info','Evaluation successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $(".radio-supplier").click(function (){
            $("#edit-evaluation-form input[name='winning_supplier']").val($(this).attr('label'));
            $("#edit-evaluation-form input[name='bid_price']").val($("td[for='"+$(this).attr('label')+"']").html().replaceAll(' ','').replaceAll(',',''));
        })

        $("#print-btn").click(function (){
            window.open("{{route('dashboard.rbac_evaluation.print',$eval->slug)}}");
        })
    </script>
@endsection