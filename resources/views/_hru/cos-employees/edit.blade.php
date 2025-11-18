@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-cos-employee-form-'.$rand,
    'slug' => $cosEmp->hr_cos_employees_slug,
])

@section('modal-header')
    {{$cosEmp->employee->full['LFEMi']}}
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.select label="Responsibility Center" name="resp_center" cols="12" id="resp_center-{{$rand}}" class="select2-parent-card" :value="$cosEmp ?? null" :options="\App\Swep\Helpers\Arrays::groupedRespCodes('all')"/>
    </div>
    <div class="mt-2">
        <x-forms.input label="Assignment" name="cos_assignment" cols="12"  :value="$cosEmp ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-cos-employee-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.cos_employees.update",$cosEmp->hr_cos_employees_slug)}}',
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Employee successfully updated.','Success');
                    active = res.hr_cos_employees_slug;
                    employeesTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection