<div class="btn-group btn-group-xs" role="toolbar" aria-label="...">
    <button type="button" class="btn btn-outline-secondary edit-sr-btn btn-sm" data-bs-toggle="modal" data-bs-target="#edit-sr-modal" data="{{$data->slug}}"><i class="fa fa-edit"></i></button>
    @if($data->due_to == 'NOSA')
        <a href="{{route('dashboard.employee.service_record',$data->slug)}}?print=true&doc=NOSA" target="_blank"  class="btn btn-outline-secondary  btn-sm"  data="{{$data->slug}}"><i class="fa fa-print"></i> NOSA</a>
    @endif
    @if($data->due_to == 'NOSI')
        <a href="{{route('dashboard.employee.service_record',$data->slug)}}?print=true&doc=NOSI" target="_blank"  class="btn btn-outline-secondary  btn-sm"  data="{{$data->slug}}"><i class="fa fa-print"></i> NOSI</a>
    @endif

    <button data="{{$data->slug}}" type="button" onclick="delete_data('{{$data->slug}}','{{route('dashboard.employee.service_record',$data->slug)}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
</div>