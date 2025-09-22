{{$data->document}}
<div class="subdetail" style="margin-top: 3px">
    Purpose: {{$data->purpose}}
    @if($data->details != null)
        <br>
        Details: {{$data->details}}
    @endif
    @if($data->request_file == 1)
        <br>
        <span class="text-danger">Requested for a soft copy</span>
    @endif
</div>