Total: <b> {{$data->employees->count()}}</b> Employees
<hr class="no-margin">
Employees uploaded evaluation form:
<div class="progress mb-3">
    @if($data->employees->count() <= 0)
        <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> {{$data->employees->where('evaluation_path','!=',null)->count()}} / {{$data->employees->count()}}</div>
    @else
        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$data->employees->where('evaluation_path','!=',null)->count() / $data->employees->count() * 100}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"> {{$data->employees->where('evaluation_path','!=',null)->count()}} / {{$data->employees->count()}}</div>

    @endif
</div>
