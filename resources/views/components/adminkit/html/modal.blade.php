<div class="modal fade" id="{{$id}}" @if($static == true) data-backdrop="static"@endif tabindex="-1" style="display: none;" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog {{!is_numeric($size) ? 'modal-'.$size : ''}}" style="{{!is_numeric($size) ? '' : '--bs-modal-width:'.$size.'%'}}" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>