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

        $employees = $employees->map(function ($data){
                return [
                    'id' => $data->slug,
                    'text' => $data->full['FMiLE']
                ];
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
        <x-slot:subtitle>Create</x-slot:subtitle>
    </x-adminkit.html.page-title>
    <form id="create-ps-form">
        <x-adminkit.html.card header-class="pb-1 pt-3">
            <x-slot:title>
                <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>

            <div class="row">
                <div class="col-md-3">
                    <x-adminkit.html.alert type="success mb-0" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        Employee(s)
                    </x-adminkit.html.alert>
                    <small><i class="fa fa-info-circle"></i> Each employee will be having separate PS</small><br>
                    <table class="table table-sm table-bordered mt-1" id="employees-table">
                        <tbody>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" class="text-center">
                                <small><a href="#" id="add-employee">Add employee</a></small>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-9">
                    <div class="row mb-2">
                        <x-forms.input label="Date of validity" name="date" cols="2" type="date"/>
                        <x-forms.select label="Personal/Official" name="personal_official" cols="2" :options="['PERSONAL' => 'PERSONAL','OFFICIAL' => 'OFFICIAL']"/>
                        <x-forms.select label="Direct/Non-Direct" name="direct_nondirect" cols="2" :options="['DIRECT' => 'DIRECT','NON-DIRECT' => 'NON-DIRECT']"/>
                        <x-forms.input label="Purpose" name="purpose" cols="6" />
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Destination" name="destination" cols="6" />
                        <x-forms.select label="Mode of transportation" name="mode_of_transportation" cols="3" :options="\App\Swep\Helpers\Arrays::modesOfTransportation()"/>

                    </div>
                    <div class="row">
                        <x-forms.select label="Immediate Supervisor" id="supervisor-select" name="supervisor_name" cols="4" :options="[]"/>
                        <x-forms.input label="Position" id="position-input" name="supervisor_position" cols="3"/>
                        <x-forms.input label="Date" name="supervisor_date" cols="2" type="date"/>
                    </div>
                </div>
            </div>
        </x-adminkit.html.card>
    </form>
    <table style="display:none;">
        <tbody id="employee-row-template">
        <tr id="employee-row-rand">
            <td>
                <div class="employees_rand">
                    <x-forms.select id="employee-select-rand" label="" name="employees[rand]" cols="12" :select-only="true"/>
                </div>
            </td>
            <td style="width: 40px;"><button class="btn btn-sm btn-danger remove_row_btn" type="button"><i class="fa fa-times"></i></button></td>
        </tr>
        </tbody>
    </table>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        let employees = {!! $employees->toJson() !!};
        let signatories = {!! $permanentEmployees->toJson() !!}
        $(document).ready(function (){
            $("#add-employee").click();
            $("#supervisor-select").select2({
                data : signatories,
            })
        })
        $('#supervisor-select').on('select2:select', function (e) {
            let data = e.params.data;
            $("#position-input").val(data.position);
        });
        $('#add-employee').click(function (){
            let template = $("#employee-row-template").html();
            let rand = makeId(8);
            console.log(rand);
            template = template.replaceAll('rand',rand);
            $("#employees-table tbody").append(template);
            $("#employee-select-"+rand).select2({
                data : employees,
            })
        })

        $("#create-ps-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.permission_slip.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#employees-table tbody").html('');
                    $("#add-employee").click();
                    let printHref = '{{route("dashboard.permission_slip.batch_print","slug")}}';
                    printHref = printHref.replace('slug',res.batch_id);
                    succeed(form,true,true);
                    Swal.fire({
                        title: 'PS successfully created.',
                        icon: 'success',
                        html: '<p>Choose what you want to do next.</p>',
                        showDenyButton: true,
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnDeny: false,
                        confirmButtonText: '<i class="fa fa-print"></i> Print PS',
                        denyButtonText: '<i class="fa fa-list"></i> My PS',
                        cancelButtonText: '<i class="fa fa-plus"></i> New PS',
                        preConfirm: (e) => {
                            window.open(printHref, "popupWindow", "width=1200, height=600, scrollbars=yes");
                            return false;
                        },
                        preDeny : (e) => {
                            window.open('{{route('dashboard.permission_slip.my')}}','_self');
                            return false;
                        },
                    })
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>



@endsection