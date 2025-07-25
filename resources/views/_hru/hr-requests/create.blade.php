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
                                    <x-forms.select :options="\App\Swep\Helpers\Arrays::db('hr_request_document')" label="What document to request" name="document" cols="12"/>
                                </div>

                                <div class="row mt-2">
                                    <x-forms.input  label="Purpose" name="purpose" cols="12"/>
                                </div>

                                <div class="row mt-2">
                                    <x-forms.textarea  label="Details (if any)" name="details" cols="12"/>
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
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.hr_requests.index")}}',
                data : form.serialize(),
                type: 'POST',
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
    </script>
@endsection