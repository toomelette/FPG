<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm show_ors_btn" data="{{$data->slug}}" data-toggle="modal" data-target="#show_ors_modal" title="" data-placement="left" data-original-title="View more">
        <i class="fa fa-file-text"></i>
    </button>
    <button class="btn btn-default btn-sm edit_ip_btn" data-bs-target="#edit_ip_modal" data-bs-toggle="modal" data="{{$data->slug}}" target="popup" title="" data-placement="left" data-original-title="Print">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" onclick="delete_data('{{$data->slug}}','{{route("dashboard.ip_address.destroy",$data->slug)}}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete">
        <i class="fa fa-trash"></i>
    </button>
</div>