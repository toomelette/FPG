<table style="width: 100%; font-size: 14px" class="tbl-padded">
    <thead>
    <tr>
        <th class="b-bottom">Date</th>
        <th class="b-bottom">Invoice #</th>
        <th class="b-bottom">Ref Book</th>
        <th class="b-bottom">Client</th>
        <th class="b-bottom">Details</th>
        <th class="b-bottom">Amount</th>
    </tr>
    </thead>
    <tbody>
    @forelse($salesInvoices as $salesInvoice)
        <tr>
            <td>{{Helper::dateFormat($salesInvoice->date,'m/d/Y')}}</td>
            <td>{{$salesInvoice->invoice_no}}</td>
            <td>{{$salesInvoice->ref_book}}</td>
            <td>{{$salesInvoice?->client?->name}}</td>
            <td>{{$salesInvoice->remarks}}</td>
            <td class="text-right">{{Helper::toNumber($salesInvoice->total_amount_due)}}</td>
        </tr>
    @empty
    @endforelse
    <tr>
        <th class="b-top">TOTAL</th>
        <th class="b-top"></th>
        <th class="b-top"></th>
        <th class="b-top"></th>
        <th class="b-top"></th>
        <th class="b-top text-right">
            {{Helper::toNumber($salesInvoices->sum('total_amount_due'))}}
        </th>

    </tr>
    </tbody>
</table>