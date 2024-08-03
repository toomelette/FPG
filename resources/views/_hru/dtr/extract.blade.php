@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Extract Biometric Data</h1>
    </section>

    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Extract Biometric Data</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="preview_extracted_from">
                                    <label>Select month:</label>
{{--                                    <div class="input-group">--}}
{{--                                        <div class="input-group-addon">--}}
{{--                                            <i class="fa fa-calendar"></i>--}}
{{--                                        </div>--}}
{{--                                        <input name="date_range" type="text" class="form-control pull-right filters" id="date_range" autocomplete="off">--}}

{{--                                    </div>--}}
                                    <input name="date_range" type="month" class="form-control pull-right filters" id="" autocomplete="off" value="{{\Carbon\Carbon::now()->format('Y-m')}}">
                                    @php
                                        $biometric_devices = \App\Models\BiometricDevices::query()->get();
                                        $bd_array = [];
                                        if(!empty($biometric_devices)){
                                            foreach ($biometric_devices as $biometric_device){
                                                $bd_array[$biometric_device->name] = $biometric_device->id;
                                            }
                                        }
                                    @endphp

                                    {!! __form::select_static(
                                    'class', 'device', 'Device', 'Value',
                                      $bd_array
                                    , '', '', '', ''
                                    ) !!}

                                    <button class="btn btn-success pull-right" style="margin-top: 10px">Preview</button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10" id="table_containter">

                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>


@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        function dt_draw() {
            users_table.draw(false);
        }

        function filter_dt() {
            is_online = $(".filter_status").val();
            is_active = $(".filter_account").val();
            users_table.ajax.url("{{ route('dashboard.user.index') }}" + "?is_online=" + is_online + "&is_active=" + is_active).load();

            $(".filters").each(function (index, el) {
                if ($(this).val() != '') {
                    $(this).parent("div").addClass('has-success');
                    $(this).siblings('label').addClass('text-green');
                } else {
                    $(this).parent("div").removeClass('has-success');
                    $(this).siblings('label').removeClass('text-green');
                }
            });
        }
        function saveAttendance(device) {
            attendance_data = attendance_tbl.rows().data();
            uid_list = [];
            $.each(attendance_tbl.rows().data(),function (i, item) {
                uid_list.push(item[0]);
            });
            $.ajax({
                url : '{{route("dashboard.dtr.store")}}',
                data : {uid_list : uid_list, device : device},
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                   console.log(res);
                },
                error: function (res) {
                    console.log(res);
                }
            })
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#date_range').daterangepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            });
        })

        $("#preview_extracted_from").submit(function (e) {
            e.preventDefault();
            form = $(this);
            $.ajax({
                url : '{{route("dashboard.dtr.extract")}}?extract=1',
                data : form.serialize(),
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                   //console.log(res);
                   $('#table_containter').html(res);

                   attendance_tbl = $("#attendance_table").DataTable();
                },
                error: function (res) {
                    console.log(res);
                }
            })
        })
    </script>


@endsection