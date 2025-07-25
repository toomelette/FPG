@php
    $employees = \App\Models\Employee::query()->active()->applyProjectId()->get();
    $employees = $employees->map(function ($data){
            return [
                'id' => $data->slug,
                'text' => $data->full['FMiLE'],
                'photo' => null,
            ];
        })->toArray();
@endphp
@extends('adminkit.master')

@section('content2')

    <div class="row">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-4">
                    <h1 class="h2">Input Time Logs</h1>
                    <p class="lead">Logged in account: <b>{{Auth::user()->employee->full['LFEMi']}}</b></p>
                </div>
                <form id="log-form">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <x-forms.select id="select-employee" label="Employee Name" :options="[]" name="employee_slug" cols="12"/>
                            </div>
                            <div class="row mt-2">
                                <x-forms.input label="Date" name="date" cols="4" type="date" :value="Carbon::now()->format('Y-m-d')"/>
                                <x-forms.input label="Morning IN" name="am_in" cols="4" type="time"/>
                                <x-forms.input label="Afternoon OUT" name="pm_out" cols="4" type="time"/>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
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
        let employeeList = {!! json_encode($employees) !!};
        $("#select-employee").select2({
            data: employeeList
        })

        $("#log-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.employee_time_logs.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection