@if($data->attachments->count() > 0)
    <ul style="list-style-type: none; padding-left: 5px">
        @forelse($data->attachments as $attachment)
            <li><a href="{{route('petty-cash-liquidations.show',$data->uuid)}}?showAttachment&id={{Crypt::encryptString($attachment->id)}}" target="_blank"><i class="fa fa-paperclip"></i> {{$attachment->original_filename}}</a></li>
        @empty
        @endforelse
    </ul>
@endif