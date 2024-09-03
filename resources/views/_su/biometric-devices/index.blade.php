@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Biometric Devices</x-slot:title>

    </x-adminkit.html.page-title>

@php
/** @var \App\Models\BiometricDevices $device **/
 @endphp
    <div class="row">
        @forelse($devices as $device)
            <div class="col-sm-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-4">
                            <h5>
                                {{$device->ip_address}}
                                <span class="float-end {{$device->status == 1 ? 'text-success' : 'text-danger'}}"><i class="fa fa-circle"></i></span>
                            </h5>
                            <span class="display-6">{{$device->name}}</span>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-1">
                                IP Address
                                <span class="float-end text-strong">{{$device->ip_address}}</span>
                            </li>
                            <li class="list-group-item p-1">
                                SN
                                <span class="float-end text-strong">{{$device->serial_no}}</span>
                            </li>
                            <li class="list-group-item p-1">
                                Last fetch
                                <span class="float-end text-strong">{{Helper::dateFormat($device->updated_at,'M. d, Y | h:i A')}}</span>
                            </li>
                            <li class="list-group-item p-1">
                                Last ID
                                <span class="float-end text-strong">{{$device->last_uid}}</span>
                            </li>
                            <li class="list-group-item p-1">
                                Last cleared
                                <span class="float-end text-strong">{{Helper::dateFormat($device->last_cleared,'M. d, Y | h:i A')}}</span>
                            </li>
                        </ul>

                        @if($device->status == 1)
                            <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Large button group">
                                <button type="button" class="btn btn-outline-secondary admin-btn" data="{{$device->id}}" data-bs-target="#admin-modal" data-bs-toggle="modal">
                                    <i class="fa fa-key"></i> <br>
                                    Admin
                                </button>
                                <button type="button" class="btn btn-outline-danger clear_attendance_btn" data="{{$device->id}}" text="Device: <b>{{$device->name}}</b> <br> IP Address: <b>{{$device->ip_address}}</b><br> <span class='text-danger text-strong'>THIS ACTION CANNOT BE UNDONE!</span> <br> <span class='text-info'>Please enter your password to continue:</span> ">
                                    <i class="fa fa-eraser"></i> <br>
                                    Clear Dev.
                                </button>
                                <button type="button" class="btn btn-outline-secondary logs-btn" data="{{$device->id}}" data-bs-target="#logs-modal" data-bs-toggle="modal">
                                    <i class="fa fa-clock"></i> <br>
                                    Attendances
                                </button>
                                <button type="button" class="btn btn-outline-secondary cron-logs-btn" data="{{$device->id}}" data-bs-target="#cron-logs-modal" data-bs-toggle="modal">
                                    <i class="fa fa-clock-rotate-left"></i> <br>
                                    Cron Logs
                                </button>
                                <button type="button" class="btn btn-outline-secondary restart_btn" data="{{$device->id}}" text="Device: <b>{{$device->name}}</b> <br> IP Address: <b>{{$device->ip_address}}</b>">
                                    <i class="fa fa-refresh"></i> <br>
                                    Restart
                                </button>
                                <button type="button" class="btn btn-outline-secondary extract_btn" data="{{$device->id}}" text="Device: <b>{{$device->name}}</b> <br> IP Address: <b>{{$device->ip_address}}</b>">
                                    <i class="fa fa-sign-out"></i> <br>
                                    Extract
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
@endsection



@section('modals')
    <x-adminkit.html.modal id="logs-modal" size="lg" />
    <x-adminkit.html.modal id="cron-logs-modal" size="lg" />
    <x-adminkit.html.modal id="admin-modal" size="sm" />
@endsection

@section('scripts')
    <script type="text/javascript">

        $(".admin-btn").click(function () {
            btn = $(this);
            load_modal2(btn);
            $.ajax({
                url : '{{route("dashboard.biometric_devices.admin")}}',
                data : {id: btn.attr('data')},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })


        $("body").on("click",".logs-btn",function () {
            let btn = $(this);
            load_modal2(btn);

            $.ajax({
                url : '{{route("dashboard.biometric_devices.attendances")}}',
                data : {id:btn.attr('data')},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        $("body").on("click",".cron-logs-btn",function () {
            let btn = $(this);
            load_modal2(btn);

            $.ajax({
                url : '{{route("dashboard.biometric_devices.index")}}?cronLogs=true',
                data : {id:btn.attr('data')},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        $(".restart_btn").click(function () {
            btn = $(this);
            var id = btn.attr('data');
            Swal.fire({
                title: 'Restart device?',
                // input: 'text',
                html: btn.attr('text'),
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-refresh"></i> Restart',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return $.ajax({
                        url : '{{route('dashboard.biometric_devices.restart')}}',
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

                    Swal.fire({
                        title: 'Restarting Device',
                        icon : 'info',
                    })
                }
            })
        })
        $(".extract_btn").click(function () {
            btn = $(this);
            var id = btn.attr('data');
            Swal.fire({
                title: 'Extract from device?',
                // input: 'text',
                html: btn.attr('text'),
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-sign-out"></i> Extract',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return $.ajax({
                        url : '{{route('dashboard.biometric_devices.extract')}}',
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
                }
            })
        })
        $(".clear_attendance_btn").click(function () {
            btn = $(this);
            var id = btn.attr('data');
            Swal.fire({
                title: 'Clear attendance from device?',
                input: 'password',
                html: btn.attr('text'),
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-eraser"></i> Clear Attendance',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    return $.ajax({
                        url : '{{route('dashboard.biometric_devices.clear_attendance')}}',
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
                        title: result.value,
                        icon : 'success',
                    })
                }
            })
        })
    </script>
@endsection