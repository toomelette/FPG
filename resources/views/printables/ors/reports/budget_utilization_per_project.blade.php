@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <table style="width: 100%;" class="tbl-padded tbl-bordered">
        <thead>
        <tr>
            <th class="text-center" rowspan="2" style="width: 90px">PAP Code</th>
            <th class="text-center" rowspan="2">PAP</th>
            <th class="text-center" colspan="3">PROPOSED BUDGET</th>
            <th class="text-center" colspan="3">UTILIZED</th>
            <th class="text-center" colspan="3">BALANCE</th>
        </tr>
        <tr>
            <th class="text-center">CO</th>
            <th class="text-center">MOOE</th>
            <th class="text-center">TOTAL</th>
            <th class="text-center">CO</th>
            <th class="text-center">MOOE</th>
            <th class="text-center">TOTAL</th>
            <th class="text-center">CO</th>
            <th class="text-center">MOOE</th>
            <th class="text-center">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @forelse($paps as $pap)
            @php
                $orginalCo = $pap->co;
                $originalMooe = $pap->mooe;
                $totalCoWithAdjustments = $pap->totalBudgetWithAdjustments()['co'];
                $totalMooeWithAdjustments = $pap->totalBudgetWithAdjustments()['mooe'];
                $totalBudget = $totalCoWithAdjustments + $totalMooeWithAdjustments;
                $totalUtilized = $pap->ors_applied_projects_sum_co + $pap->ors_applied_projects_sum_mooe;
            @endphp
            <tr>
                <td>{{$pap->pap_code}}</td>
                <td>{{$pap->pap_title}}</td>
                <td class="text-right">{{Helper::toNumber($totalCoWithAdjustments,2)}}</td>
                <td class="text-right">{{Helper::toNumber($totalMooeWithAdjustments,2)}}</td>
                <td class="text-right">{{Helper::toNumber($totalBudget,2)}}</td>
                <td class="text-right">{{Helper::toNumber($pap->ors_applied_projects_sum_co,2)}}</td>
                <td class="text-right">{{Helper::toNumber($pap->ors_applied_projects_sum_mooe,2)}}</td>
                <td class="text-right">{{Helper::toNumber($totalUtilized,2)}}</td>
                <td class="text-right">{{Helper::toNumber($balCo = $totalCoWithAdjustments - $pap->ors_applied_projects_sum_co,2)}}</td>
                <td class="text-right">{{Helper::toNumber($balMooe = $totalMooeWithAdjustments - $pap->ors_applied_projects_sum_mooe,2)}}</td>
                <td class="text-right">{{Helper::toNumber($balCo + $balMooe,2)}}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            let set = 625;
            if ($("#items_table_{{$rand}}").height() < set) {
                let rem = set - $("#items_table_{{$rand}}").height();
                $("#adjuster").css('height', rem)
                print();
            }
        })
        window.onafterprint = function () {
            window.close();
        }
    </script>
@endsection