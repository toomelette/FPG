<table style="width: 100%; font-size: 12px" class="table-borderless">
    <thead>
    <tr>
        <td class="text-center" style="border-bottom: 1px solid darkgray">Description</td>
        <td class="text-center" style="border-bottom: 1px solid darkgray; width: 20%;">DR</td>
        <td class="text-center" style="border-bottom: 1px solid darkgray; width: 20%;">CR</td>
    </tr>
    </thead>
    @forelse($data->details as $detail)
        @php
            $class = '';
            if($detail->sales_invoice_uuid != Request::route('sales_invoice')){
                $class = 'strike';
            }
        @endphp
        <tr>
            <td class="{{$class}}">{{$detail->description}}</td>
            <td class="text-end {{$class}}">{{Helper::toNumber($detail->debit)}}</td>
            <td class="text-end {{$class}}">{{Helper::toNumber($detail->credit)}}</td>
        </tr>
    @empty
    @endforelse
    <tr>
        <td style="border-top: 1px solid darkgray">TOTAL</td>
        <td class="text-end" style="border-top: 1px solid darkgray">{{Helper::toNumber($data->details->where('sales_invoice_uuid', '=',Request::route('sales_invoice'))->sum('debit'))}}</td>
        <td class="text-end" style="border-top: 1px solid darkgray">{{Helper::toNumber($data->details->where('sales_invoice_uuid', '=',Request::route('sales_invoice'))->sum('credit'))}}</td>

    </tr>
</table>