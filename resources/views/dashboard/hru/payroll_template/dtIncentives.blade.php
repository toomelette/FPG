@php
    $half = ceil($data->nonZeroIncentives->count() / 2);
    $chunked = $data->nonZeroIncentives->chunk($half);
@endphp
<span class="text-strong text-right">{{Helper::toNumber($data->nonZeroIncentives->sum('amount'))}}</span>
<div class="table-subdetail" style="margin-top: 3px">
    <div class="row">
        @forelse($chunked as $chunk)
            <div class="col-md-{{12/2}}">
                <table style="width: 100%">
                    <tbody>
                    <tr>
                        <td>Incentives</td>
                        <td class="text-right">Amount</td>
                    </tr>
                    @forelse($chunk as $nonZeroIncentive)
                        <tr>
                            <td style="padding-right: 10px">{{$nonZeroIncentive->incentive_code}}</td>
                            <td class="text-right text-strong">{{Helper::toNumber($nonZeroIncentive->amount,2)}}</td>
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
