@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'update-status-form-'.$rand,
    'slug' => $hrRequest->slug,
])

@section('modal-header')
    Update Status | <small>{{$hrRequest->tracking_no}}</small>
@endsection

@section('modal-body')
    @php
        $statusCollection = collect($hrRequest->status_trail);
        $statusCollection->sortBy('timestamp');
        $userIds = $statusCollection->pluck('user')->unique();
        $userIds->push($hrRequest->user_created);
        $usersUsed = \App\Models\User::query()
            ->with(['employee'])
            ->whereIn('user_id',$userIds)
            ->get();
    @endphp
    <div class="row">
        <div class="col-md-8">
            <!-- Section: Timeline -->
            <section>
                <ul class="timeline">
                    <li class="timeline-item mb-2">
                        <h5 class="fw-bold">Request for {{$hrRequest->document}} was created.</h5>
                        <p class="text-muted mb-1 fw-bold">{{Helper::dateFormat($hrRequest->created_at,'d F Y | h:i A')}}</p>
                        <p class="text-muted">
                            {{$usersUsed->where('user_id','=',$hrRequest->user_created)?->first()?->employee?->full['FMiLE']}}
                        </p>
                    </li>

                    @if(!empty($statusCollection))
                        @foreach($statusCollection as $status)
                            <li class="timeline-item mb-2">
                                <h5 class="fw-bold">{{$status['status']}}</h5>
                                <p class="text-muted mb-2 fw-bold">{{Carbon::parse($status['timestamp'])->setTimezone('Asia/Macao')->format('d F Y | h:i A')}}</p>
                                <p class="text-muted">
                                    {{$usersUsed->where('user_id','=',$status['user'])?->first()?->employee?->full['FMiLE']}}
                                </p>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </section>
            <!-- Section: Timeline -->
        </div>
        <div class="col-md-4">
            <div class="row">
                <x-forms.select :options="\App\Swep\Helpers\Arrays::db('hr_request_status')" label="Status" name="status" cols="12"/>
            </div>
            <button class="btn btn-sm btn-primary float-end mt-2" type="submit"><i class="fas fa-check"></i> Save</button>
        </div>
    </div>

@endsection

@section('modal-footer')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#update-status-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.hr_requests.update","slug")}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    active = res.slug;
                    requestsTbl.draw(false);
                    toast('info','Status successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection