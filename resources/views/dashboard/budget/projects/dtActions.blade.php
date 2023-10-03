<div class="btn-group">
    <a href="{{route('dashboard.projects.show',$data->slug)}}"  type="button" class="btn btn-default btn-sm list_submenus_btn"  title="" data-placement="left" data-original-title="Submenus">
        <i class="fa fa-list"></i>
    </a>
    <button type="button" data="{{$data->slug}}" class="btn btn-default btn-sm edit_pap_btn" data-toggle="modal" data-target="#edit_pap_modal" title="" data-placement="top" data-original-title="Edit">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" onclick="delete_data('{{$data->slug}}','{{route("dashboard.projects.destroy",$data->slug)}}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete">
        <i class="fa fa-trash"></i>
    </button>
    <div class="btn-group btn-group-sm" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
                <a  data="{{$data->slug}}" data-toggle="modal" class="realignmentAndSupplementalModal_btn" data-target="#realignmentAndSupplementalModal" target="popup" href="#" title="" data-placement="left" data-original-title="Print"> Realignment & Supplemental</a>
            </li>
{{--            <li>--}}
{{--                <a  data="{{$data->slug}}" target="popup"  title="" data-placement="left" data-original-title="Print"><i class="fa fa-print"></i> Print with ORS Entries</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a  data="{{$data->slug}}" target="popup"  title="" data-placement="left" data-original-title="Print"><i class="fa fa-print"></i> Print attachment</a>--}}
{{--            </li>--}}
        </ul>
    </div>
</div>
{{--<a href="?pap={{$data->slug}}" ><button class="btn btn-default btn-sm" data="{{$data->slug}}" style="margin-top: 5px; width: 97px"> <i class="fa icon-procurement"></i> PPMP</button></a>--}}
