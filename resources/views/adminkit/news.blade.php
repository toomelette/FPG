@forelse($news as $new)
    @php
        $cArray = [];
        foreach (request()->cookies as $key => $c){
            $cArray[$key] = 1;
        }
    @endphp
    @if(!isset($cArray['news_'.$new->slug]))
        <div class="news-trigger" style="cursor: pointer" data="{{$new->slug}}"  data-bs-target="#news-modal" data-bs-toggle="modal">
            <div class="alert alert-danger  alert-dismissible" role="alert">
                <button type="button" class="btn-close news-close" data-bs-dismiss="alert" aria-label="Close" data="{{$new->slug}}"></button>
                <div class="alert-message">
                    <h4 class="alert-heading text-strong">{{$new->title}}!</h4>
                    {!! Str::of(strip_tags($new->details))->replace('&nbsp;',' ')->limit(130) !!}
                    @if($new->attachments->count() > 0 )
                        <br>
                        <small>With {{$new->attachments->count()}} {{Str::plural('attachment',$new->attachments->count())}}</small>
                    @endif
                </div>
            </div>
        </div>
    @endif
@empty
@endforelse