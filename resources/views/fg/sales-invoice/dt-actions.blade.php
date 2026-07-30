<div class="btn-group btn-group-sm">
    <a href="{{route('sales-invoice.show',$data->uuid)}}" type="button" class="btn btn-outline-secondary btn-sm view-sales-invoice-btn" data="{{$data->uuid}}">
        <i class="fa fa-file-text"></i>
    </a>
    <button href="{{route('sales-invoice.print',$data->uuid)}}" for="linkToEdit" type="button"
       class="btn btn-outline-secondary btn-sm print-btn-dialog">
        <i class="fa fa-print"></i>
    </button>
    <a href="{{route('sales-invoice.edit',$data->uuid)}}" for="linkToEdit" type="button"
            class="btn btn-outline-secondary btn-sm ">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("sales-invoice.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li class="dropdown-item print-btn-dialog" href="{{route('sales-invoice.print',$data->uuid)}}?summary">
                Print Summary
            </li>
            <a class="dropdown-item" target="_blank" href="{{route('sales-invoice.print',$data->uuid)}}?summary&excel=true">
                Excel Summary
            </a>
            @if($data->status == 'CANCELLED')
                <button class="dropdown-item cancel-invoice-btn" data="{{$data->uuid}}" data-action="uncancel">
                    Uncancel Invoice
                </button>
            @else
                <button class="dropdown-item cancel-invoice-btn" data="{{$data->uuid}}" data-action="cancel">
                    Cancel Invoice
                </button>
            @endif
        </ul>
    </div>
</div>