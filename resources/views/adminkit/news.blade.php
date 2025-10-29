@forelse($news as $new)
    @php
        $cArray = [];
        foreach (request()->cookies as $key => $c){
            $cArray[$key] = 1;
        }
    @endphp
    @if(!isset($cArray['news_'.$new->slug]))
        <div class="news-trigger" style="cursor: pointer" data="{{$new->slug}}"  data-bs-target="#news-modal" data-bs-toggle="modal">
            <div class="alert alert-info  alert-dismissible" role="alert">
                <button type="button" class="btn-close news-close" data-bs-dismiss="alert" aria-label="Close" data="{{$new->slug}}"></button>
                <div class="alert-message">
                    <h4 class="alert-heading text-strong">{{$new->title}}!</h4>
                    {!! Str::of(strip_tags($new->details))->replace('&nbsp;',' ')->limit(130) !!}
                </div>
            </div>
        </div>
    @endif
@empty
@endforelse