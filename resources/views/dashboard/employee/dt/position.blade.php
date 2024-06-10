<span class="{{empty($data->plantilla) && ($data->appointment_status != 'COS' ) ? 'text-danger' : ''}}">
    <b>{{$data->plantilla->position ?? $data->position}}</b>
</span>
<span class="pull-right text-strong text-success">{{$data->item_no ?? ''}}</span>
<div class="table-subdetail">
    JG-Step: {{$data->salary_grade}} - {{$data->step_inc}}
    <span class="pull-right">Monthly Basic: {{number_format($data->monthly_basic,2)}}</span>
</div>

<div class="table-subdetail">
    <i>Department:</i> <br>
    <span class="text-info text-strong">
        {{$data->responsibilityCenter->desc ?? '-'}}
    </span>
</div>

