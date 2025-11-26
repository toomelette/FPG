@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Employee</x-slot:title>
        <x-slot:subtitle>Batch Actions</x-slot:subtitle>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            Incomplete Service Record Data
        </x-slot:title>
        @php
            $employees = \App\Models\Employee::query()
                ->with([
                    'employeeServiceRecord' => function ($employeeServiceRecord) {
                        $employeeServiceRecord->orderBy('sequence_no');
                    },
                    'plantilla',
                ])
                ->active()
                ->permanent()
                ->applyProjectId()
                ->orderBy('lastname')
                ->get();
            $employeeItemNos = $employees->mapWithKeys(function ($data){
                return [
                    $data->slug => $data->item_no,
                ];
            });
        @endphp

        <table class="table table-sm table-striped table-bordered">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Seq #</th>
                <th>Dates</th>
                <th>Item No.</th>

            </tr>
            </thead>
            <tbody>
            @forelse($employees as $employee)
                @if($employee->employeeServiceRecord->count() > 0)
                    @if($employee->employeeServiceRecord->last()->item_no == null)
                        @php
                            $last = $employee->employeeServiceRecord->last();
                        @endphp
                        <tr>
                            <td class="v-top text-strong">
                                <a href="{{route('dashboard.employee.service_record',$employee->slug)}}" target="_blank">{{$employee->full['LFEMi']}}</a>
                            </td>
                            <td class="text-center v-top">{{$last->sequence_no}}</td>
                            <td class="v-top">{{Helper::dateFormat($last->from_date)}} to {{$last->to_date != null ? $last->to_date : 'PRESENT'}}</td>
                            <td style="width: 60%">
                                <form class="update-lastest-sr-form" id="sr-{{$last->slug}}" data="{{$last->slug}}">
                                    <div class="row">
                                        <x-forms.select id="item-no-{{$employee->slug}}" label="Item No. (If applicable)" name="item_no" class="item-no" cols="6" :options="[]"/>
                                        <x-forms.input label="Position" name="position" cols="6" :value="$employee?->plantilla?->position"/>
                                    </div>
                                    <div class="row mt-2">
                                        <x-forms.select label="Salary Type" name="salary_type" cols="3" :options="\App\Swep\Helpers\Arrays::salaryTypes()" :value="$last ?? null"/>
                                        <x-forms.input label="SG/JG/PG" name="grade" cols="2" type="number" :value="$employee->salary_grade ?? null"/>
                                        <x-forms.select label="Step" name="step" cols="2" :options="\App\Swep\Helpers\Arrays::stepIncements()" :value="$employee->step_inc ?? null"/>
                                        <x-forms.select label="Due to" name="due_to" cols="2"  :options="\App\Swep\Helpers\Arrays::serviceRecordDueTo()" :value="$last ?? null"/>
                                        <x-forms.input label="Monthly Basic Salary" name="monthly_basic" cols="3"  class="autonum text-end"  :value="$employee ?? null"/>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary mt-2 mb-3"><i class="fa fa-check"></i> Save</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endif
            @empty
            @endforelse
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection
@php
    $plantillas = \App\Models\HRPayPlanitilla::query()
        ->with(['responsibilityCenter'])
        ->get()
        ->map(function ($plantilla){
            return [
                'id' => $plantilla->item_no,
                'text' => $plantilla->item_no .' - '.$plantilla->position .' --- ('.$plantilla?->responsibilityCenter?->desc.')',
                'position' => $plantilla->position,
                'JG' => $plantilla->original_job_grade,
                'SG' => $plantilla->original_salary_grade,
                'PG' => $plantilla->original_salary_grade,
                'resp_center' => $plantilla?->responsibilityCenter?->desc
            ];
        });
@endphp
@section('scripts')
    <script type="text/javascript">
        $(".update-lastest-sr-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.batch.update","slug")}}?updateLastestSr';
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
                    succeed(form,true,false);
                    form.parents('tr').slideUp();
                    toast('info','Service record updated successfully','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        let plantillas = {!! $plantillas->toJson() !!};
        let employeeItemNos = {!! $employeeItemNos->toJson() !!};
        $(".item-no").select2({
            data: plantillas,
        });

        $('.item-no').on('select2:select', function (e) {
            let data = e.params.data;
            let form = $(this).parents('form');
            form.find('input[name="position"]').val(data.position);
            form.find('input[name="grade"]').val(data.JG);
        });

        $.each(employeeItemNos,function (slug,itemNo){
            $("#item-no-"+slug).val(itemNo).trigger('change');
        });
    </script>
@endsection