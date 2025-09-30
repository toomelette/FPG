{{Helper::toNumber($data->monthly_basic)}}
@if($data->monthly_basic != null)
    <hr class="no-margin">
    {{$data->salary_type}}: {{$data->grade}}, {{$data->step}}
@endif
