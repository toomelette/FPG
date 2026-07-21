<b>{{$data->project_id}}</b>
<hr class="mt-1 mb-0">
<small>Can access:</small> <br>
<b class="text-info">{{implode(', ',$data->project_access ?? [])}}</b>
