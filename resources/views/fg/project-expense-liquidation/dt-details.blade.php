<table style="width: 100%; font-size: 12px" class="table-borderless">
    <thead>
    <tr>
        <td class="text-center" style="border-bottom: 1px solid darkgray">Invoice No.</td>
        <td class="text-center" style="border-bottom: 1px solid darkgray">Project</td>
        <td class="text-center" style="border-bottom: 1px solid darkgray; width: 15%;">DR</td>
        <td class="text-center" style="border-bottom: 1px solid darkgray; width: 15%;">CR</td>
    </tr>
    </thead>
    @php
        $detailsBySalesInvoice = $data->details->groupBy('sales_invoice_uuid')
    @endphp
    @forelse($detailsBySalesInvoice as $details)
        <tr>
            @php
                $route = '';
                switch ($details->first()?->salesInvoice?->ref_book){
                    case 'CASH' : $route = route('sales-invoice.index'); break;
                    case 'CHARGE' : $route = route('charge-sales-invoice.index'); break;
                    case 'BILLING' : $route = route('billing.index'); break;
                    default: '';
                }
            @endphp
            <td><a href="{{$route}}?find={{$details->first()?->sales_invoice_uuid}}" target="_blank">{{$details->first()?->salesInvoice?->invoice_no}}</a></td>
            <td>{{Str::of($details->first()?->salesInvoice?->remarks)->limit(50)}}</td>
            <td class="text-end">{{Helper::toNumber($details->sum('debit'))}}</td>
            <td class="text-end">{{Helper::toNumber($details->sum('credit'))}}</td>

        </tr>
    @empty
    @endforelse
    <tr>
        <td style="border-top: 1px solid darkgray">TOTAL</td>
        <td style="border-top: 1px solid darkgray"></td>
        <td style="border-top: 1px solid darkgray" class="text-end">{{Helper::toNumber($data->details->sum('debit'))}}</td>
        <td style="border-top: 1px solid darkgray" class="text-end">{{Helper::toNumber($data->details->sum('credit'))}}</td>

    </tr>
</table>