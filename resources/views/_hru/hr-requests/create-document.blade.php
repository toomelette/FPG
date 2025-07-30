@extends('adminkit.master')

@section('content2')

    <x-adminkit.html.page-title>
        <x-slot:title>Create Document</x-slot:title>
        <x-slot:subtitle>{{$hrRequest->document}}</x-slot:subtitle>
        <x-slot:float-end>{{$hrRequest->employee->full['LFEMi']}}</x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="row">
            <div class="col-md-2">
                <dl class="dl-horizontal" style="">
                    <dt>Requester:</dt>
                    <dd>{{$hrRequest->employee->full['LFEMi']}}</dd>
                </dl>
            </div>
            <div class="col-md-2">
                <dl class="dl-horizontal" style="">
                    <dt>Date of Request:</dt>
                    <dd>{{Carbon::parse($hrRequest->crated_at)->format('M. d, Y | h:i A') }}</dd>
                </dl>
            </div>
            <div class="col-md-2">
                <dl class="dl-horizontal" style="">
                    <dt>Tracking No:</dt>
                    <dd>{{$hrRequest->tracking_no}}</dd>
                </dl>
            </div>
            <div class="col-md-3">
                <dl class="dl-horizontal" style="">
                    <dt>Requested Document:</dt>
                    <dd>{{$hrRequest->document}} <br><i>{{$hrRequest->purpose}}</i></dd>
                </dl>
            </div>
            <div class="col-md-3">
                <dl class="dl-horizontal" style="">
                    <dt>Request Details:</dt>
                    <dd>{{$hrRequest->details}}</dd>
                </dl>
            </div>
        </div>
    </x-adminkit.html.card>

    @switch($hrRequest->document)
        @case('Certificate of Employment')
            @include('_hru.hr-requests.portion-coe')
        @break
        @case('Certificate of Employment and Compensation')
            @include('_hru.hr-requests.portion-coe-and-compensation')
            @break
        @case('Certificate of Engagement as COS')
            @include('_hru.hr-requests.portion-coe-cos')
            @break
        @case('Certificate of Engagement as COS with Compensation')
            @include('_hru.hr-requests.portion-coe-and-compensation-cos')
            @break
    @endswitch

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            CKEDITOR.replace('editor',{
                height: '130px',
                toolbarCollapse: true
            });
        });

        $(function () {
            CKEDITOR.replace('editor2',{
                height: '100px'
            });
        });

        $(function () {
            CKEDITOR.replace('editor3',{
                height: '180px'
            });
        });

        $(".generate-document-form").submit(function (e){
            e.preventDefault();
            let form = $(this);
            let iframe = form.parents('.row').find('.print-iframe');
            let placeholderContainer = form.parents('.row').find('.placeholder-container');
            let printContainer = form.parents('.row').find('.print-container');
            if(CKEDITOR.instances !== undefined){
                $.each(CKEDITOR.instances,function (i,value){
                    CKEDITOR.instances[i].updateElement();
                })
            }
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.hr_requests.create_document",$hrRequest->slug)}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    iframe.attr('src',res.link);
                    placeholderContainer.hide();
                    printContainer.show();
                    succeed(form,false,false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $(".print-btn").click(function (){
            let btn = $(this);
            btn.siblings('.print-iframe').get(0).contentWindow.print();
        })

        let signatories = {!! json_encode(\App\Swep\Helpers\Arrays::coeSignatories()) !!}
        $(".select2-coe-signatories").select2({
            data : signatories,
        })
        $('.select2-coe-signatories').on('select2:select', function (e) {
            let data = e.params.data;
            let form = $(this).parents('form');
            let signatoryPosition = form.find('input[name="signatory_position"]');
            signatoryPosition.val(data.position);
        });

        $('.select2-coe-signatories').val('{{$document_fields['signatory_name'] ?? null}}').trigger('change');




    </script>
@endsection