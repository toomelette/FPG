<div class="btn-group">
    <a href="{{route('dashboard.cash_disbursements.print',$data->slug)}}" target="_blank" class="btn btn-default btn-sm show_ors_btn" title="" data-placement="left" data-original-title="View more">
        <i class="fa fa-print"></i>
    </a>
    <a class="btn btn-default btn-sm" data="{{$data->slug}}" target="_self" href="{{route('dashboard.cash_disbursements.edit',$data->slug)}}"title="" data-placement="left" data-original-title="Print">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" onclick="delete_data('{{$data->slug}}','{{route("dashboard.cash_disbursements.destroy",$data->slug)}}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete">
        <i class="fa fa-trash"></i>
    </button>
    <div class="btn-group btn-group-sm" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
                <a  data="{{$data->slug}}" target="popup" href="{{route('dashboard.cash_disbursements.print',$data->slug)}}"title="" data-placement="left" data-original-title="Print"><i class="fa fa-print"></i> Print</a>
            </li>
            <li>
                <a  data="{{$data->slug}}" target="popup" href="{{route('dashboard.cash_disbursements.print',$data->slug)}}?withOrsEntries=true&accountEntriesPerPage=12" title="" data-placement="left" data-original-title="Print"><i class="fa fa-print"></i> Print with ORS Entries</a>
            </li>
            <li>
                <a  data="{{$data->slug}}" target="popup" href="{{route('dashboard.cash_disbursements.print',$data->slug)}}?attachment=true" title="" data-placement="left" data-original-title="Print"><i class="fa fa-print"></i> Print attachment</a>
            </li>
        </ul>
    </div>
</div>