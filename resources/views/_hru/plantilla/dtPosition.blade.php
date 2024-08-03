<span class="text-strong">{{$data->position}}</span>
<div class="subdetail" style="margin-top: 3px">
    {{$data->department}}
    @if($data->division != 'NONE')
        <p class="no-margin " style="padding-left: 20px"> <i class="fa fa-chevron-right"></i> {{$data->division}}</p>
    @endif
    @if($data->section != 'NONE')
        <p class="no-margin " stle="padding-left: 40px"> <i class="fa fa-chevron-right"></i>{{$data->section}}</p>

    @endif
</div>
