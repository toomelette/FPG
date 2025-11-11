@php
    /** @var \App\Models\Employee $employee **/
    $employee->load(['employeeAddress','employeeFamilyDetail','employeeChildren'])
@endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Profile</x-slot:title>
    </x-adminkit.html.page-title>

    <div class="row">
        <div class="col-md-3 col-xl-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Settings</h5>
                </div>

                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab" aria-selected="true">
                        Account
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#educ" role="tab" aria-selected="false" tabindex="-1">
                        Education & Eligibility
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#service-records" role="tab" aria-selected="false" tabindex="-1">
                        Service Records
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#trainings" role="tab" aria-selected="false" tabindex="-1">
                        Trainings
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab" aria-selected="false" tabindex="-1">
                        Password & Login
                    </a>
                    @if(Helper::isPermanent(Auth::user()->employee))
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#payslip" role="tab" aria-selected="false" tabindex="-1">
                            Payslips <span class="sidebar-badge badge bg-success">Beta</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade active show" id="account" role="tabpanel">
                    @include('_profile.tab-account ')
                </div>
                <div class="tab-pane fade" id="educ" role="tabpanel">
                    @include('_profile.tab-educ')
                </div>
                <div class="tab-pane fade" id="service-records" role="tabpanel">
                    @include('_profile.tab-service-records')
                </div>
                <div class="tab-pane fade" id="trainings" role="tabpanel">
                    @include('_profile.tab-trainings')
                </div>
                <div class="tab-pane fade" id="password" role="tabpanel">
                    @include('_profile.tab-password')
                </div>
                @if(Helper::isPermanent(Auth::user()->employee))
                    <div class="tab-pane fade" id="payslip" role="tabpanel">
                        @include('_profile.tab-payslip')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#change-pass-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.profile.update_password")}}';
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
                    toast('info','Password successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })

        $(".payslip-btn").click(function (){
            let url = '{{route('dashboard.profile.payslip')}}';
            let btn = $(this);
            Swal.fire({
                title: '',
                input: 'password',
                html: 'Enter your password to proceed:',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check"></i> Continue',
                showLoaderOnConfirm: true,
                confirmButtonColor: '#0d6efd',
                preConfirm: (password) => {
                    return $.ajax({
                        url : url,
                        type: 'POST',
                        data: {
                            'password':password,
                            'month' : btn.attr('data'),
                            'payroll' : btn.attr('payroll'),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (res){
                            window.open(res, '_blank');
                        }
                    })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            );
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (!result.isConfirmed) {

                }
            })
        })

        $(".sign-out-btn").click(function (){
            let btn = $(this);
            $.ajax({
                url : '{{route('dashboard.profile.sign_out_device')}}',
                data : {
                    session_id : btn.attr('data'),
                },
                type: 'DELETE',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('success','Account successfully logged out.','Success');
                    btn.parents('tr').fadeOut();
                },
                error: function (res) {
                    toast('error',res.responseJSON.message,'Success');
                }
            })
        })
    </script>
@endsection