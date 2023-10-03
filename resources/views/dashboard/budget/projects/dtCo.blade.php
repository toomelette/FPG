@php
    $totalBudget = $data->totalBudgetWithAdjustments()['co'];
@endphp
@if($totalBudget != null && $totalBudget != 0)
    <label class="no-margin">{{number_format($totalBudget,2)}}</label>
    <div class="table-subdetail text-left">
        <table style="width: 100%">
            <tr>
                <td>Bal:</td>
                <td class="text-right">
                    @php
                        $balance = $totalBudget - $data->orsAppliedProjects->sum('co');
                    @endphp
                    @if($totalBudget != $balance)
                        <span class="text-green">{{\App\Swep\Helpers\Helper::toNumber($balance,2)}}</span>
                    @else
                        {{\App\Swep\Helpers\Helper::toNumber($balance,2)}}
                    @endif

                </td>
            </tr>
        </table>
    </div>
@else
    -
@endif