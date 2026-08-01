@if($data->attachments->count() > 0)
    @php
        $chunkedAttachments = $data->attachments->chunk(2);
    @endphp

        @forelse($chunkedAttachments as $attachments)
            <div class="row">
            @forelse($attachments as $attachment)
                <div class="col-md-6">
                    <a href="{{route('petty-cash-liquidations.show',$data->uuid)}}?showAttachment&id={{Crypt::encryptString($attachment->id)}}" target="_blank"><i class="fa fa-paperclip"></i> {{$attachment->original_filename}}</a>
                </div>
                @empty
            @endforelse
            </div>
        @empty
        @endforelse
    <ul style="list-style-type: none; padding-left: 5px">
        <li><a href="#" data-bs-target="#show-files-modal" class="show-files-button" data="{{$data->uuid}}" data-bs-toggle="modal"><i class="fa fa-eye"></i> View all files</a></li>
    </ul>

@endif