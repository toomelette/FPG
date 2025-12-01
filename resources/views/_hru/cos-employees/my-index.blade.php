@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Contract of Service</x-slot:title>
    </x-adminkit.html.page-title>

    <div class="row">
        <div class="col-md-4">

            <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2" style="min-height: 500px">
                <x-slot:title>
                    1. Upload duly signed evaluation form
                </x-slot:title>

                @if(!empty($cosEmp->evaluation_path))
                    <div class="text-center pt-6">
                        <a href="{{request()->getUri()}}?viewEvaluation" target="_blank">
                            <span style="font-size: 72px"><i class="fa fa-file-pdf"></i></span>
                            <p>View file</p>
                        </a>
                        <h4 class="no-margin text-success"><i class="fa fa-check-circle "></i></h4>
                        <p class="small">Uploaded at: {{Carbon::parse($cosEmp->evaluation_uploaded_at)->format('F d, Y h:i A')}}</p>
                    </div>
                @else
                    <form id="upload-eval-form">
                        <div class="row">
                            <div class="col-md-12 doc_file">
                                <div class="file-loading ">
                                    <input id="doc-file" name="doc_file" type="file" multiple>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload</button>
                            </div>
                        </div>

                    </form>
                @endif

            </x-adminkit.html.card>
        </div>
        <div class="col-md-4">
            <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2" style="min-height: 500px">
                <x-slot:title>
                    2. Update other data and signatories
                </x-slot:title>
                @php
                    $otherData = $cosEmp->other_data;
                @endphp
                <form id="signatories-form">
                    <x-forms.select label="Civil Status" name="civil_status" cols="12" :options="\App\Swep\Helpers\Arrays::civil_status()" :value="$otherData['civil_status'] ?? null"/>
                    <x-forms.input label="Address" name="address" cols="12 mt-2" :value="$otherData['address'] ?? null"/>

                    <x-forms.select label="Witness #1" class="signatories" name="witness_1" id="witness_1" cols="12" :options="[]" :value="$otherData['witness_1'] ?? null"/>
                    <x-forms.select label="Witness #2" class="signatories" name="witness_2" id="witness_2" cols="12 mt-2" :options="[]" :value="$otherData['witness_2'] ?? null"/>

                    <x-adminkit.html.alert type="success mt-3" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        ID:
                    </x-adminkit.html.alert>
                    <div class="row">
                        <x-forms.input label="Valid ID"  name="valid_id" cols="6" :value="$otherData['valid_id'] ?? null"/>
                        <x-forms.input label="Issued at"  name="valid_id_issued_at" cols="6" :value="$otherData['valid_id_issued_at'] ?? null"/>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button class="btn btn-primary btn-sm float-end" type="submit"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-4">
            <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2" style="min-height: 500px">
                <x-slot:title>
                    3. Download and print contract
                </x-slot:title>
                @if($cosEmp->status == 'APPROVED')
                    <div class="text-center pt-6">
                        <a href="{{request()->getUri()}}?printContract" target="_blank" class="text-success">
                            <span style="font-size: 72px"><i class="fa fa-file-pdf"></i></span>
                            <p>HR prepares your contract</p>
                        </a>
                    </div>
                @else
                    <div class="alert alert-info alert-outline-coloured alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            Please wait until your contract is ready.
                        </div>
                    </div>
                @endif
            </x-adminkit.html.card>
        </div>
    </div>

@endsection


@section('modals')

@endsection
@php
    $signatories = \App\Models\Employee::query()
            ->active()
            ->permanent()
            ->orderBy('lastname')
            ->get()
            ->map(function ($data){
                return [
                    'id' => $data->slug,
                    'text' => $data->full['FMiLE'],                ];
            })->values();

@endphp
@section('scripts')
    <script type="text/javascript">
        let url1 = null;
        uploader = $("#doc-file").fileinput({
            // uploadUrl: "",
            enableResumableUpload: false,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            deleteExtraData: {

            },
            maxFileCount: 1,
            minFileCount: 0,
            initialPreviewAsData: true,
            overwriteInitial: true,
            theme: 'fa',
            browseOnZoneClick: true,
            showBrowse: true,
            showCaption: false,
            showRemove: false,
            showUpload: false,
            showCancel: false,
            uploadAsync: false,
        })

        $("#upload-eval-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form)
            $.ajax({
                url : '{{route("dashboard.my_cos.uploadEvaluation",request()->route('slug'))}}',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Document was uploaded successfully.','Success!');
                    location.reload();
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        });


        let signatories = {!! $signatories->toJson() !!};
        $(".signatories").select2({
            data : signatories,
        })

        $("#signatories-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.my_cos.updateData",request()->route('slug'))}}',
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('success','Data successfully updated','Success');
                    active = res.slug;
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $(document).ready(function (){
            $("#witness_1").val('{{$otherData['witness_1'] ?? null}}').trigger('change');
            $("#witness_2").val('{{$otherData['witness_2'] ?? null}}').trigger('change');
        })
    </script>
@endsection