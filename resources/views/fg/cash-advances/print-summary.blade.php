@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <tr>
                <td style="width: 80%;">
                    <p class="no-margin text-strong" style="font-size: 28px">{{\App\Swep\Helpers\Get::company()}}</p>
                    <p class="no-margin" style="font-size: 18px">{{\App\Swep\Helpers\Get::address()}}</p>
                </td>
            </tr>
        </table>
        <br>

        <p class="text-center text-strong" style="font-size: 16px">CASH ADVANCES SUMMARY</p>
        <p class="text-strong" >{{\App\Swep\Helpers\Helper::concatenate(request('project_id'),request('type'))}}</p>
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-all" rowspan="2">Date</th>
                @if(blank(request('project_id')))
                    <th class="text-center b-all" rowspan="2">Office</th>
                @endif
                @if(blank(request('type')))
                    <th class="text-center b-all" rowspan="2">Type</th>
                @endif
                <th class="text-center b-all" rowspan="2">Requested By</th>
                <th class="text-center b-all" rowspan="2">Reason</th>
                <th class="text-center b-all" colspan="2">Amount</th>
            </tr>
            <tr>
                <th class="text-center b-all">Requested</th>
                <th class="text-center b-all">Approved</th>
            </tr>
            </thead>
            <tbody>
            @forelse($cashAdvances as $cashAdvance)
                <tr>
                    <td class="text-center">{{Helper::dateFormat($cashAdvance->date,'m/d/Y')}}</td>
                    @if(blank(request('project_id')))
                        <td>{{$cashAdvance->project_id}}</td>
                    @endif
                    @if(blank(request('type')))
                        <td>{{$cashAdvance->type}}</td>
                    @endif
                    <td>{{$cashAdvance->requested_by}}</td>
                    <td>{{$cashAdvance->reason}}</td>
                    <td class="text-right">{{Helper::toNumber($cashAdvance->amount_requested)}}</td>
                    <td class="text-right">{{Helper::toNumber($cashAdvance->amount_approved)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th colspan="5" class="b-top">TOTAL</th>
                <th class="text-right b-top">{{Helper::toNumber($cashAdvances->sum('amount_requested'))}}</th>
                <th class="text-right b-top">{{Helper::toNumber($cashAdvances->sum('amount_approved'))}}</th>

            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
@endsection