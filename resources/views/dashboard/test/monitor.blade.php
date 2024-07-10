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
        window.Echo.channel('testing-channel')
            .listen('.test-broadcast', (e) => {
                toast('success',e.data,'Message:',false);
                setInterval(function (){
                    var d = new Date();
                    var secs = d.getSeconds();
                    if(secs % 2 === 0  ){
                        $("title").html('New Message.');
                    }else{
                        $("title").html('SRA Web Portal - HRRS');
                    }

                },1000)
            })

        console.log("websokets in use")


    </script>
@endsection