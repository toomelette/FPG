@extends('adminkit.master')

@section('content2')
    @php
        $employees = \App\Models\Employee::query()
            ->with(['plantilla'])
            ->active()
            ->orderBy('lastname')
            ->get();

        $permanentEmployees = $employees->filter(function ($data){
            return ($data->locations == 'VISAYAS' || $data->locations == 'LUZON/MINDANAO') && ($data->plantilla->job_grade ?? 0) > 10;
        });


        $permanentEmployees = $permanentEmployees->sortByDesc(function ($data){
            return $data->plantilla->job_grade ?? 0;
        });

        $permanentEmployees = $permanentEmployees->map(function ($data){
                return [
                    'id' => $data->full['FMiLE'],
                    'text' => $data->full['FMiLE'],
                    'position' => $data->plantilla->position ?? '',
                ];
            })->values();

    @endphp

    <x-adminkit.html.page-title>
        <x-slot:title>Permission Slip</x-slot:title>
        <x-slot:subtitle>Edit</x-slot:subtitle>
    </x-adminkit.html.page-title>
    <form id="edit-ps-form">
        <x-adminkit.html.card header-class="pb-1 pt-3">
            <x-slot:title>
                <div class="btn-group float-end">
                    <button type="button" class="btn btn-outline-secondary btn-sm " id="print-btn"><i class="fa fa-print"></i> Print</button>
                    <button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i> Save</button>
                </div>
            </x-slot:title>
            <div class="row mb-2">
                <x-forms.input label="Employee" name="employee_name" cols="2" :value="$ps->employee_name ?? null" disabled="disabled"/>
                <x-forms.input label="Date of validity" name="date" cols="2" type="date" :value="$ps ?? null"/>
                <x-forms.select label="Personal/Official" name="personal_official" cols="2" :options="['PERSONAL' => 'PERSONAL','OFFICIAL' => 'OFFICIAL']" :value="$ps ?? null"/>
                <x-forms.select label="Direct/Non-Direct" name="direct_nondirect" cols="2" :options="['DIRECT' => 'DIRECT','NON-DIRECT' => 'NON-DIRECT']" :value="$ps ?? null"/>
                <x-forms.input label="Purpose" name="purpose" cols="4"  :value="$ps ?? null"/>
            </div>
            <div class="row mb-2">
                <x-forms.input label="Destination" name="destination" cols="6"  :value="$ps ?? null"/>
                <x-forms.select label="Mode of transportation" name="mode_of_transportation" cols="3" :options="\App\Swep\Helpers\Arrays::modesOfTransportation()" :value="$ps ?? null"/>

            </div>
            <div class="row">
                <x-forms.select label="Immediate Supervisor" id="supervisor-select" name="supervisor_name" cols="4" :value="$ps ?? null"/>
                <x-forms.input label="Position" id="position-input" name="supervisor_position" cols="3" :value="$ps ?? null"/>
                <x-forms.input label="Date" name="supervisor_date" cols="2" type="date" :value="$ps ?? null"/>
            </div>

        </x-adminkit.html.card>
    </form>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        let signatories = {!! $permanentEmployees->toJson() !!}
        $(document).ready(function (){
            $("#supervisor-select").select2({
                data : signatories,
            })
            $("#supervisor-select").val('{{$ps->supervisor_name}}');
            $('#supervisor-select').trigger('change');
        })
        $('#supervisor-select').on('select2:select', function (e) {
            let data = e.params.data;
            $("#position-input").val(data.position);
        });

        $("#edit-ps-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.permission_slip.update",$ps->slug)}}';
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,false);
                    toast('info','PS successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })

        $("#print-btn").click(function (){
            let href ='{{route('dashboard.permission_slip.print',$ps->slug)}}';
            window.open(href, "popupWindow", "width=1200, height=600, scrollbars=yes");
        })
    </script>
@endsection