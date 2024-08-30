@php
$rand = Str::random();
/** @var \App\Models\BiometricDevices $device **/
 @endphp
@extends('adminkit.modal')

@section('modal-header')
    {{$device->name}}
@endsection

@section('modal-body')
    <dl>
        <dt>USER ID:</dt>
        <dd>{{$admin['userid']}}</dd>
        <dt>Current Password:</dt>
        <dd for="password_{{$rand}}">{{$admin['password']}}</dd>
        <dt>User Level:</dt>
        <dd>
            @switch($admin['role'])
                @case(14)
                    ADMIN
                    @break
                @default
                    STANDARD
                    @break
            @endswitch
        </dd>
    </dl>
    <button class="btn btn-sm col-md-12 btn-danger" id="clear_admin_{{$rand}}" data="{{$device->id}}">RESET ADMIN PASSWORD</button><br><br>
    <button class="btn btn-sm col-md-12 btn-primary" id="change_pass_{{$rand}}" data="{{$device->id}}">CHANGE PASSWORD</button>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Close</button>

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#clear_admin_{{$rand}}").click(function () {
            btn = $(this);
            var id = btn.attr('data');
            Swal.fire({
                title: 'Are you sure you want to reset admin password?',

                html: "After resetting, use the following credentials: <br>USER: <b>999</b> <br>PASS: <b>1234</b>",
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-eraser"></i> RESET',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    return $.ajax({
                        url : '{{route('dashboard.biometric_devices.clear_admin')}}',
                        type: 'POST',
                        data: {'id':id},
                        headers: {
                            {!! __html::token_header() !!}
                        },
                    })
                        .then(response => {
                            return  response;
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    Swal.fire({
                        title: result.value,
                        icon : 'success',
                    })
                    $("dd[for='password_{{$rand}}']").html(result.value.new_pass);
                }
            })
        });
        $("#change_pass_{{$rand}}").click(function () {
            btn = $(this);
            var id = btn.attr('data');
            Swal.fire({
                title: 'Enter new password for the device:',
                input: 'number',
                html: "Password must be 4 characters. <br>Only numbers from 0-9 are allowed.",
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-eraser"></i> Apply changes',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    return $.ajax({
                        url : '{{route('dashboard.biometric_devices.admin_change_password')}}',
                        type: 'POST',
                        data: {'id':id, 'password':password},
                        headers: {
                            {!! __html::token_header() !!}
                        },
                    })
                        .then(response => {
                            return  response;
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    Swal.fire({
                        title: result.value.text,
                        icon : 'success',
                    })
                    $("dd[for='password_{{$rand}}']").html(result.value.new_pass);
                }
            })
        })
    </script>
@endsection