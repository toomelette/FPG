{{$data->document}}
<div class="subdetail" style="margin-top: 3px">
    Purpose: {{$data->purpose}}
    @if($data->details != null)
        <br>
        Details: {{$data->details}}
    @endif
</div>