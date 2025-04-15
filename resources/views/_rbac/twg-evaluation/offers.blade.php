<div class="row mb-3">
    <x-forms.input label="Item/s" name="items" cols="6" value="{{$aq->details->pluck('item')->implode('; ')}}"/>
    <x-forms.input label="Approved budget" name="abc" cols="2" :value="$aq->abc" />
    <x-forms.select label="Mode of Procurement" name="abc" cols="2" :options="\App\Swep\Helpers\Arrays::modesOfProcurement()" />
</div>
<table class="table table-sm table-bordered" style="font-size: 12px">
    <thead>
    <tr>
        <th class="text-center">Item</th>
        <th class="text-center" style="width: 3%">Qty</th>
        @forelse($aq->aq->pluck('supplier_slug') as $supplier_slug)
            <th colspan="2" class="text-center" style="width: {{80/$aq->aq->count()}}%">{{$suppliers->where('slug',$supplier_slug)->first()->name}}</th>
        @empty
        @endforelse
    </tr>
    </thead>
<tbody>

@forelse($aq->details as $detail)
    <tr>
        <td>{{$detail->item}}</td>
        <td>{{$detail->qty}}</td>
        @forelse($aq->aq->pluck('supplier_slug') as $supplier_slug)
            <td>{{$detail->offers->where('aq.supplier_slug',$supplier_slug)->first()->description}}</td>
            <td style="width: 100px" class="text-end">{{Helper::toNumber($detail->offers->where('aq.supplier_slug',$supplier_slug)->first()->amount)}}</td>
        @empty
        @endforelse
    </tr>
@empty
</tbody>
</table>


@endforelse
<tfoot>
<tr>
    <th colspan="2">Total</th>
    @forelse($aq->aq->pluck('supplier_slug') as $supplier_slug)
        <td></td>
        <td style="width: 100px" class="text-end"></td>
    @empty
    @endforelse
</tr>
</tfoot>
