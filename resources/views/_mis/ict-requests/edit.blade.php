@php
    $rand = Str::random();
    /** @var \App\Models\MisRequests $ict **/
    /** @var \App\Models\Employee $requisitioner **/
@endphp
@extends('adminkit.modal',[
'id' => 'edit-request-form-'.$rand,
'slug' => $ict->slug,
])

@section('modal-header')
    {{$ict->nature_of_request}} - {{$requisitioner}}
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-7">
            <x-adminkit.html.alert type="primary" :dismissible="false" :with-icon="false" body-class="p-1 text-center ">
                <strong>Request Details</strong>
            </x-adminkit.html.alert>
            <dl class="dl-horizontal" style="padding-bottom:60px;">
                <dt>Request No:</dt>
                <dd>{{$ict->request_no}}</dd>

                <dt>Date and Time:</dt>
                <dd>{{\Carbon\Carbon::parse($ict->created_at)->format('F d, Y | h:i A')}}</dd>

                <dt>Nature of request:</dt>
                <dd>{{$ict->nature_of_request}}</dd>

                <dt>Request Details:</dt>
                <dd>{{$ict->request_details}}</dd>

                <dt>Requisitioner:</dt>
                <dd for="requisitioner">{{$requisitioner}}</dd>

                <dt>Summary of Diagnosis:</dt>
                <dd for="summary_of_diagnostics">{{$ict->summary_of_diagnostics}}</dd>

                <dt>Recommendation:</dt>
                <dd for="recommendations">{{$ict->recommendations}}</dd>

                <dt>Latest Status:</dt>
                <dd for="status">
                    @if($ict->status()->count() > 0)
                        {{$ict->status()->first()->status}}
                    @endif
                </dd>

                <dt>Returned:</dt>
                <dd for="returned">{{$ict->returned}}</dd>

                <dt>Date returned:</dt>
                <dd for="date_returned">{{$ict->date_returned}}</dd>
            </dl>
        </div>
        <div class="col-md-5">
            <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center ">
                <strong>Actions</strong>
            </x-adminkit.html.alert>

            <form id="edit_request_form_{{$rand}}" data="{{$ict->slug}}" >
                <div class="row">
                    <x-forms.input label="Recommendation" name="recommendations" container-class="mb-2" cols="12" :value="$ict ?? null"/>
                    <x-forms.input label="Summary of Diagnostics" name="summary_of_diagnostics" container-class="mb-2" cols="12" :value="$ict ?? null"/>
                    <x-forms.input label="Returned" name="returned" container-class="mb-2" cols="12" :value="$ict ?? null"/>
                    <x-forms.input label="Date Returned (if equipment)" name="date_returned" container-class="mb-2" cols="12" type="date" :value="$ict ?? null"/>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i>  Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('modal-footer')
<button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal"> Close</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#edit-request-form-{{$rand}}").submit(function (e) {
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