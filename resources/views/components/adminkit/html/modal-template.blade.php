<div class="modal fade" id="{{$id}}" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog {{!is_numeric($size) ? 'modal-'.$size : ''}}" style="{{is_numeric($size) ? '--bs-modal-width: '.$size.'%' : ''}}" role="document">
        <div class="modal-content">
            @if($formId != null)
                <form id="{{$formId}}" target="{{$formTarget}}" method="{{$formMethod}}" action="{{$formAction}}" data="{{$formData}}">
            @endif
                <div class="modal-header">
                    <h5 class="modal-title">{{$title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{$slot}}
                </div>
                <div class="modal-footer">
                    {{$footer}}
                </div>
            @if($formId != null)
                </form>
            @endif
        </div>
    </div>
</div>