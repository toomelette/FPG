<span class="{{empty($data->plantilla) && ($data->appointment_status != 'COS' ) ? 'text-danger' : ''}}">
    <b>{{$data->plantilla->position ?? $data->position}}</b>
</span>
<span class="float-end text-right text-strong text-success">{{$data->item_no ?? ''}}</span>
<div class="subdetail">
    Grade-Step: {{$data->salary_grade}} - {{$data->step_inc}}
    @if(Route::currentRouteName() == 'dashboard.employee.index')
        <span class="float-end">Monthly Basic: {{number_format($data->monthly_basic,2)}}</span>
    @else
        <span class="float-end">Monthly Basic: {{number_format($data->monthly_basic,2)}}</span>
    @endif
</div>

<div class="table-subdetail">
    <i>Department:</i> <br>
    <span class="text-info text-strong">
        {{$data->responsibilityCenter->desc ?? '-'}}
    </span>
</div>

