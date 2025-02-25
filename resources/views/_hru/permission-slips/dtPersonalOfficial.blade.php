{{$data->personal_official}}
@if($data->personal_official == 'PERSONAL')
    <div class="subdetail" style="margin-top: 3px">
        <span>PS No. <u><b>{{$data->ps_frequency}}</b></u> for {{Carbon::make($data->date)->format('F Y')}}</span>
    </div>
@endif