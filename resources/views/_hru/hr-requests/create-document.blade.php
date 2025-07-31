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
    <style>
        .cke_top, .cke_bottom {
            display: none;
        }
        .cke_editable {
            font-size: 24px; /* Match the body font size */
        }
    </style>

    <div class="row">
        <div class="col-md-4">
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
        </div>
        <div class="col-md-8">
            <div>
                <x-adminkit.html.card>
                    <div class="placeholder-container mt-5 pt-5 pb-5 mb-5" style="{{empty($hrRequest->document_fields) ? '' : 'display:none;'}} ">
                        <div class="text-center">
                            <h1 class="display-1 fw-bold text-muted"><i class="fa fa-print"></i></h1>
                            <p class="lead fw-normal mt-3 mb-4">Print Preview</p>
                        </div>
                    </div>
                    <div class="print-container" style="{{!empty($hrRequest->document_fields) ? '' : 'display:none;'}} ">
                        <button class="btn btn-sm btn-secondary float-end print-btn" type="button"><i class="fa fa-print"></i> Print</button>
                        <iframe src="{{empty($hrRequest->document_fields) ? '' : route('dashboard.hr_requests.print',$hrRequest->slug)}}" class="print-iframe" style="width: 100%; height: 1000px"></iframe>
                    </div>
                </x-adminkit.html.card>
            </div>
        </div>
    </div>


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