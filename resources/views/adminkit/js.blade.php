<script type="text/javascript">
    const modal_loader_placeholder = '<div id="modal_loader_placeholder"><div class="text-center pt-5 pb-5" style="font-size: 50px"><i class="fas fa-fw fa-circle-notch fa-spin"></i></div></div>';
</script>

<script type="text/javascript" src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('template/bower_components/select2/dist/js/select2.full.min.js') }}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>--}}
<script src="{{asset('adminkit/adminkit-plugins/select2/select2-full.js')}}"></script>


<script type="text/javascript" src="{{asset('template/plugins/autoNumeric/autoNumeric.js')}}"></script>
<script type="text/javascript" src="{{asset('template/plugins/jquery-number/jquery.number.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/toast/src/jquery.toast.js') }}"></script>


<script src="{{asset('adminkit/adminkit-plugins/datatables/datatable.js')}}"></script>


<script type="text/javascript" src="{{asset('template/plugins/swal2/dist/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('template/bower_components/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{asset('template/plugins/IntroJs/introjs.js')}}"></script>


<script type="text/javascript" src="{{ asset('adminkit/adminkit-js/app2.js') }}?{{Carbon::now()->format('Y-m-d:H')}}"></script>

<script type="text/javascript" src="{{asset('template/plugins/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{ asset('template/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminkit/plugins/bs-fileinput-v5.5.4-1/js/fileinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/ajax-file-uploader/dist/jquery.uploader.min.js') }}"></script>
<script type="text/javascript" src="{{asset('template/plugins/jquery-sortable/source/js/jquery-sortable-min.js')}}"></script>
<script type="text/javascript" src="{{asset('template/plugins/typeahead/js/bootstrap-typeahead.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('template/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/plugins/iCheck/icheck.min.js') }}"></script>


<script type="text/javascript">
    function filterDT(datatable_object){

        let data = $("#filter_form").serialize();
        datatable_object.ajax.url("{{\Illuminate\Support\Facades\URL::current()}}"+"?"+data).load();

        $(".dt_filter").each(function (index,el) {
            if ($(this).val() != '' && $(this).val() != 'NULL'){
                $(this).parent("div").addClass('has-success');
                $(this).siblings('label').addClass('text-green');
            } else {
                $(this).parent("div").removeClass('has-success');
                $(this).siblings('label').removeClass('text-green');
            }
        });
        let withSuccess = $('.dt_filter-parent-div.has-success');
        if(withSuccess.length > 0){
            $("#filter-notifier").html(withSuccess.length+' filter(s) currently active');
        }else{
            $("#filter-notifier").html('');
        }
    }

    $(document).ready(function (){

        @if(Request::has('initiator'))
            introJs().start();
            window.history.pushState({}, document.title, "/{{Request::path()}}")
        @endif
    })

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