@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>TITLE HERE</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        Content

    </section>

@endsection


@section('modals')

@endsection


@section('scripts')
    <script>
        var module = { };
    </script>

    <script type="module">

        import Echo from '{{ asset('node/ws/echo.js') }}'

        import {Pusher} from '{{asset('node/ws/pusher.js')}}'

        window.Pusher = Pusher

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'abcdefg',
            wsHost: window.location.hostname,
            wsPort: 5001,
            forceTLS: false,
            disableStats: true,
        });
        ;
        window.Echo.channel('private-mis-request')
            .listen('.new-request', (e) => {

                let changer = setInterval(function (){
                    var d = new Date();
                    var secs = d.getSeconds();
                    if(secs % 2 === 0  ){
                        $("title").html(e.title);
                    }else{
                        $("title").html('SRA Web Portal - HRRS');
                    }
                },1000);

                $.toast({
                    text: e.message, // Text that is to be shown in the toast
                    heading: e.title, // Optional heading to be shown on the toast
                    icon: 'info', // Type of toast icon
                    showHideTransition: 'slide', // fade, slide or plain
                    hideAfter: false, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                    position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                    textAlign: 'left',  // Text alignment i.e. left, right or center
                    loader: false,  // Whether to show loader or not. True by default
                    loaderBg: '#9EC600',  // Background color of the toast loader
                    afterHidden: function () {
                        $("title").html('SRA Web Portal - HRRS');
                        clearInterval(changer);
                    }
                });
            })

        console.log("websockets in use")


    </script>
@endsection