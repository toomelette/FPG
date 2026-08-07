@if($data->check_amount != null && $data->check_amount != '' && $data->check_amount != 0)
    {{Helper::toNumber($data->check_amount)}}
    <hr class="mt-1 mb-0">
    <p class="small no-margin">{{$data->bank}} | {{$data->check_no}}</p>
@endif