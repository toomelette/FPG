@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'add-multiple-employees-form-'.$rand,
    'slug' => $cos->slug,
])

@section('modal-header')
    Add employees
@endsection

@section('modal-body')
    <table class="table table-sm table-bordered table-striped" id="emp-table-{{$rand}}">
        <thead>
        <tr>
            <th>
                <label>
                    <input id="overall-selector-{{$rand}}" type="checkbox" checked>
                </label>
            </th>
            <th class="hide-this">Slug</th>
            <th>Full Name</th>
            <th>Position</th>
            <th>Resp Center</th>
            <th>Assignment</th>
            <th>Salary</th>
        </tr>
        </thead>
        <tbody>
        @forelse($employees as $employee)
            <tr>
                <td>
                    <label>
                        <input class="employee-selector-{{$rand}}" type="checkbox" checked name="employees[{{$employee->slug}}][checked]" value="{{$employee->slug}}">
                    </label>
                </td>
                <td class="hide-this">
                    <x-forms.input label="Assignment" name="slug" cols="12" :input-only="true" :value="$employee->slug"/>

                </td>
                <td>{{$employee->full['LFEMi'] ?? null}}</td>
                <td>{{$employee->position}}</td>
                <td>{{$employee->responsibilityCenter->long_name ?? $employee->responsibilityCenter->desc ?? null}}</td>
                <td>
                    <x-forms.input label="Assignment" name="employees[{{$employee->slug}}][assignment]" cols="12" :input-only="true" :value="$employee->responsibilityCenter->long_name ?? $employee->responsibilityCenter->desc ?? null"/>
                </td>
                <td class="text-end">{{Helper::toNumber($employee->monthly_basic)}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No data found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>


@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#overall-selector-{{$rand}}").iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass   : 'iradio_flat-green'
        })
        $('.employee-selector-{{$rand}}').iCheck({
            checkboxClass: 'icheckbox_flat-blue checkbox-counter',
            radioClass   : 'iradio_flat-green'
        })

        $("body").on('ifUnchecked','#overall-selector-{{$rand}}',function (event){
            $('.employee-selector-{{$rand}}').iCheck('uncheck');
        })
        $("body").on('ifChecked','#overall-selector-{{$rand}}',function (event){
            $('.employee-selector-{{$rand}}').iCheck('check');
        })



        $("#add-multiple-employees-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.cos_employees.store",$cos->slug)}}?multiple',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Employees successfully added.','Success');
                    employeesTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection