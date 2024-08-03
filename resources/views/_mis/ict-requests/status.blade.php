@php
    /** @var \App\Models\MisRequests $r **/
@endphp
@extends('adminkit.modal')

@section('modal-header')
    {{$r->request_no}} - {{$r->nature_of_request}} - Status
@endsection

@section('modal-body')
    @php
        $timeline = [];
        if(!empty($r->status()->count() > 0)){
            $r->status()->orderBy('created_at','asc');
            foreach ($r->status as $status){
                $timeline[\Carbon\Carbon::parse($status->created_at)->format('Y-m-d')][$status->slug] = $status;
            }
        }
    @endphp
    <div class="well well-sm">
        <ul class="timeline">

            <!-- timeline time label -->


            @if(count($timeline) > 0)
                @foreach($timeline as $key => $date)
                    <li class="time-label">
                        <span class="bg-blue">
                            <strong>{{\Carbon\Carbon::parse($key)->format('M d, Y')}}</strong>
                        </span>
                    </li>
                    @if(count($date) > 0)
                        @foreach($date as $status)
                            <li>
                                <!-- timeline icon -->
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> </span>
                                    <div class="chat-message-left pb-4">
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                            <div class="font-weight-bold mb-1 text-strong">{{$status->status}}</div>
                                            {{\Carbon\Carbon::parse($status->created_at)->format('M d, Y | h:i A')}}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            @endif



            <li class="time-label">
                <span class="bg-teal">
                    <strong>{{\Carbon\Carbon::parse($r->created_at)->format('M d. Y')}}</strong>
                </span>
            </li>

            <li>

                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> </span>
                    <div class="chat-message-left pb-4">
                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                            <div class="font-weight-bold mb-1 text-strong">Request was made</div>
                            {{\Carbon\Carbon::parse($r->created_at)->format('M d. Y | h:i A')}}
                        </div>
                    </div>
                </div>

            </li>

        </ul>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal"> Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection