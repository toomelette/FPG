@php($rand = \Illuminate\Support\Str::random(10))
@extends('layouts.modal-content')

@section('modal-header')
    {{$r->request_no}} - {{$r->nature_of_request}}
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-7">
            <div class="well well-sm">
                <dl class="dl-horizontal" style="padding-bottom:60px;">
                    <dt>Request No:</dt>
                    <dd>{{$r->request_no}}</dd>

                    <dt>Date and Time:</dt>
                    <dd>{{\Carbon\Carbon::parse($r->created_at)->format('F d, Y | h:i A')}}</dd>

                    <dt>Nature of request:</dt>
                    <dd>{{$r->nature_of_request}}</dd>

                    <dt>Request Details:</dt>
                    <dd>{{$r->request_details}}</dd>

                    <dt>Requisitioner:</dt>
                    <dd for="requisitioner">{{$requisitioner}}</dd>

                    <dt>Summary of Diagnosis:</dt>
                    <dd for="summary_of_diagnostics">{{$r->summary_of_diagnostics}}</dd>

                    <dt>Recommendation:</dt>
                    <dd for="recommendations">{{$r->recommendations}}</dd>

                    <dt>Latest Status:</dt>
                    <dd for="status">
                        @if($r->status()->count() > 0)
                            {{$r->status()->first()->status}}
                        @endif
                    </dd>

                    <dt>Returned:</dt>
                    <dd for="returned">{{$r->returned}}</dd>

                    <dt>Date returned:</dt>
                    <dd for="date_returned">{{$r->date_returned}}</dd>
                </dl>
            </div>
        </div>
        <div class="col-md-5">
            <div class="well well-sm">
                <form id="edit_request_form_{{$rand}}" data="{{$r->slug}}" >
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('recommendations',[
                            'cols' => 12,
                            'label' => 'Recommendation: ',
                        ],
                        $r
                        ) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('summary_of_diagnostics',[
                            'cols' => 12,
                            'label' => 'Summary of Diagnostics: ',
                        ],
                        $r
                        ) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('returned',[
                            'cols' => 12,
                            'label' => 'Returned: ',
                        ],
                        $r
                        ) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date_returned',[
                            'cols' => 12,
                            'label' => 'Date Returned: (if equipment):',
                            'type' => 'date',
                        ],
                        $r
                        ) !!}

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-check"></i>  Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modal-footer')
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit_request_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.mis_requests.update","slug")}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                   succeed(form,false,false);
                   $.each(res, function (i,item) {
                       $("dd[for='"+i+"']").html(item);
                   })
                    notify('Request successfully updated.','success');
                    active = res.slug;
                   requests_tbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                    console.log(res);
                }
            })
        })
    </script>
@endsection

