@php
    $half = ceil($data->nonZeroDeductions->count() / 2);
    $chunked = $data->nonZeroDeductions->chunk($half);
@endphp
    <span class="text-strong text-right">{{Helper::toNumber($data->nonZeroDeductions->sum('amount'))}}</span>
    <div class="table-subdetail" style="margin-top: 3px">
        <div class="row">
            @forelse($chunked as $chunk)
                <div class="col-md-{{12/2}}">
                    <table style="width: 100%">
                        <tbody>
                        <tr>
                            <td>Deduction</td>
                            <td class="text-right">Amount</td>
                        </tr>
                        @forelse($chunk as $nonZeroDeduction)
                            <tr>
                                <td style="padding-right: 10px">{{$nonZeroDeduction->deduction_code}}</td>
                                <td class="text-right text-strong">{{Helper::toNumber($nonZeroDeduction->amount,2)}}</td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @empty
            @endforelse
        </div>
    </div>
