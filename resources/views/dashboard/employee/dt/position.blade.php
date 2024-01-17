@if($sql_server_is_on === true)
    @if(!empty($data->empMaster))
        {{$data->position}}
        <span class="pull-right text-strong">{{$data->item_no ?? ''}}</span>
        <div class="table-subdetail">
            JG-Step: {{$data->empMaster->SalGrade}} - {{$data->empMaster->StepInc}}
            <span class="pull-right">Monthly Basic: {{number_format($data->empMaster->MonthlyBasic,2)}}</span>
        </div>
    @else
        {{$data->position}}  <span class="pull-right text-strong">{{$data->item_no ?? ''}}</span>
        <div class="table-subdetail" style="color: #d9534f !important;">No data available</div>
    @endif
@else
    {{$data->position}} <span class="pull-right text-strong">{{$data->item_no ?? ''}}</span>
@endif

<div class="table-subdetail">
    <i>Department:</i> <br>
    <span class="text-info">
        {{$data->responsibilityCenter->desc ?? '-'}}
    </span>
</div>

