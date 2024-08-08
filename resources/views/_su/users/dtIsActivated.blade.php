@if($data->is_activated == 1)
    <span class="badge bg-primary" style="width: 100%;">
        ACTIVE
    </span>
@else
    <span class="badge bg-danger" style="width: 100%;">
        DEACTIVATED
    </span>
@endif