@isset($id)
    <form id= "{{$id}}"
          @if(isset($slug))
              data="{{$slug}}"
          @endif

          @if(isset($uri))
              uri="{{$uri}}"
            @endif

    >
        @csrf
        @endisset

        <div class="modal-header">
            <h5 class="modal-title">
                @yield('modal-header')
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @php($style = '')
        @isset($decolor)
            @php($style = '#ecf0f5')
        @endisset
        <div class="modal-body"  style="background-color: {{$style}}">
            @yield('modal-body')
        </div>


        <div class="modal-footer">
            @yield('modal-footer')
        </div>


        @isset($id)
    </form>
@endisset

@yield('scripts')