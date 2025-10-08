@extends('adminkit.master')

@section('content2')

    <div class="row">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <form id="request-form">
                    <div class="card">
                        <div class="card-header pb-1">
                            Create a Request for Certification & Other HR Documents
                        </div>
                        <div class="card-body">

                            <div id="form-container">
                                <dl class="dl-horizontal" style="">
                                    <dt>Name:</dt>
                                    <dd>{{Auth::user()->employee->full['LFEMi']}}</dd>

                                    <dt>Email:</dt>
                                    <dd>
                                        {{Auth::user()->employee->email}}<br>
                                        <small class="text-info">Updates will be sent to this email. If it is incorrect, kindly contact the HR Section for updating.</small>
                                    </dd>
                                </dl>
                                <div class="row">
                                    <div class="col-md-6">
                                        <dl class="dl-horizontal">
                                            <dt>Position:</dt>
                                            <dd>
                                                {{Auth::user()->employee->plantilla->position ?? Auth::user()->employee->position}}<br>
                                            </dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-6">
                                        <dl class="dl-horizontal">
                                            <dt>First Day in SRA as {{Helper::isPermanent(Auth::user()->employee) ? 'permanent' : 'COS'}}:</dt>
                                            <dd>
                                                {{Helper::dateFormat(Auth::user()->employee->firstday_sra,'F d, Y')}}<br>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <p class="text-danger"> Please check if the data above are correct. Put some instructions in the "Details" box if some of the data are inaccurate.</p>

                                <div class="row mt-2">
                                    <x-forms.select :options="\App\Swep\Helpers\Arrays::db('hr_request_document',Helper::isPermanent(Auth::user()->employee) ? 'PERM' : 'COS')" label="What document to request" name="document" id="hr_request_document" cols="12"/>
                                </div>

                                <div id="non-cos-container">
                                    <div class="row mt-2">
                                        <x-forms.input  label="Purpose" name="purpose" cols="12"/>
                                    </div>

                                    <div class="row mt-2">
                                        <x-forms.textarea  label="Details (if any)" name="details" cols="12"/>
                                    </div>
                                    <div class="row mt-2">
                                        <x-forms.checkbox label="Soft copy"
                                                          type="checkbox"
                                                          name="request_file"
                                                          cols="12"
                                                          each-class="12"
                                                          :options="['1' => 'Request a soft copy']"
                                                          :value="[]"
                                        />
                                        <span class="text-info small"><i class="fa fa-info-circle"></i> (Soft copy will be available in <b>MY REQUESTS</b> tab once uploaded by HR Personnel)</span>
                                    </div>
                                </div>

                                <div class="row mt-3" id="cos-container" style="display: none">
                                    <div class="col-md-12 doc_file">
                                        <label for="lastname">Upload evaluation form:</label>
                                        <div class="file-loading ">
                                            <input id="doc-file" name="doc_file" type="file" multiple>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
                                    </div>
                                </div>


                            </div>
                            <div id="success-message" style="display: none">
                                <div class="text-center">
                                    <h1 class="display-1 fw-bold text-success"><i class="fa fa-check-circle"></i></h1>
                                    <p class="h2">Request successfully submitted.</p>
                                    <p class="fw-normal mt-3 mb-2">We'll send updates on your email once HR Personnel has already taken action. </p>
                                    <p class="fw-normal mt-2">Here is your tracking number:</p>
                                    <p class="h1"><code id="tracking-no"></code></p>
                                    <p class="fw-normal mt-2 text-info">You may also see the status of your request in <a href="{{route('dashboard.hr_requests.my_index')}}"><u><b>"My Request"</b></u></a> Tab under the Certifications and Other Doc.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#request-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.hr_requests.index")}}',
                data : formData,
                type: 'POST',
                processData: false,
                contentType: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('success','Request successfully submitted.','Success!')
                    $("#form-container").hide();
                    $("#tracking-no").html(res.tracking_no);
                    $("#success-message").slideDown();
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("#hr_request_document").change(function (){
            let t = $(this);
            let cos = $("#cos-container");
            let nonCos = $("#non-cos-container");
            if(t.val().includes('Contract of Service')){
                cos.fadeIn();
                nonCos.hide();
            }else{
                nonCos.fadeIn();
                cos.hide();
            }
        })

        $(document).ready(function (){
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
                showBrowse: false,
                showCaption: false,
                showRemove: false,
                showUpload: false,
                showCancel: false,
                uploadAsync: false,
            }).on('fileloaded', function(event, previewId, index, fileId) {
                $(".kv-file-upload").each(function () {
                    $(this).remove();
                })
            }).on('fileuploaderror', function(event, data, msg) {
                icon = $("#confirm_payment_btn i");
                icon.removeClass('fa-spinner');
                icon.removeClass('fa-spin');
                icon.addClass(' fa-check');
                $("#confirm_payment_btn").removeAttr('disabled');
                console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
            }).on('filebatchuploaderror', function(event, data, msg) {
                icon = $("#confirm_payment_btn i");
                icon.removeClass('fa-spinner');
                icon.removeClass('fa-spin');
                icon.addClass(' fa-check');
                $("#confirm_payment_btn").removeAttr('disabled');
                console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
            }).on('filebatchuploadsuccess', function(event, data) {

            }).on('fileerror',function(event,data,msg){

            });
        });
    </script>
@endsection