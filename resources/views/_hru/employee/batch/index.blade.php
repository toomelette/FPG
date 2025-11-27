@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Employee</x-slot:title>
        <x-slot:subtitle>Batch Actions</x-slot:subtitle>
    </x-adminkit.html.page-title>

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
        $serviceRecordDueTo = \App\Swep\Helpers\Arrays::serviceRecordDueTo();
        $salaryTableScales = \App\Swep\Helpers\Arrays::salaryTableScales();
        $salaryTypes = \App\Swep\Helpers\Arrays::salaryTypes();
    @endphp

    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Incomplete Service Record Data</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link " href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Add New Service Records</a></li>

            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Messages</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-2" role="tabpanel">
                <h4 class="tab-title">Incomplete Service Record Data</h4>


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
                                                <x-forms.select label="Salary Type" name="salary_type" cols="3" :options="$salaryTypes" :value="$last ?? null"/>
                                                <x-forms.input  label="SG/JG/PG" name="grade" cols="2" type="number" :value="$employee->salary_grade ?? null"/>
                                                <x-forms.select  label="Step" name="step" cols="2" :options="\App\Swep\Helpers\Arrays::stepIncements()" :value="$employee->step_inc ?? null"/>
                                                <x-forms.select label="Due to" name="due_to" cols="2"  :options="$serviceRecordDueTo" :value="$last ?? null"/>
                                                <x-forms.input  label="Monthly Basic Salary" name="monthly_basic" cols="3"  class="autonum text-end"  :value="$employee ?? null"/>
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
            </div>
            <div class="tab-pane " id="tab-1" role="tabpanel">
                <h4 class="tab-title">Add New Service Records</h4>

                <h4 class="tab-title">Edit all fields:</h4>
                <div class="row mb-3">
                    <x-forms.input class="val" label="Date from" name="from_date" cols="2" type="date" :input-group="true" input-group-text="<i class='fa fa-check'></i>" input-group-class="btn-primary apply-many"/>
                    <x-forms.input class="val" label="Date to" name="to_date" cols="2" type="date" :input-group="true" input-group-text="<i class='fa fa-check'></i>" input-group-class="btn-primary apply-many"/>
                    <x-forms.select class="val"  :input-group="true" label="Due to" name="due_to" cols="2" :options="$serviceRecordDueTo" input-group-text="<i class='fa fa-check'></i>" input-group-class="btn-primary apply-many"/>
                    <x-forms.select class="val"  :input-group="true" label="Salary Scale" name="salary_scale" cols="2" :options="$salaryTableScales" input-group-text="<i class='fa fa-check'></i>" input-group-class="btn-primary apply-many"/>
                    <x-forms.select class="val"  :input-group="true" label="Salary Type" name="salary_type" cols="2" :options="$salaryTypes" input-group-text="<i class='fa fa-check'></i>" input-group-class="btn-primary apply-many"/>
                </div>
                <table class="table table-sm table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Last Service Record</th>
                        <th>New Service Record</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($employees as $employee)
                        @php
                            $last = $employee->employeeServiceRecord->last();
                        @endphp
                        @if($last->batch_code != \App\Swep\Helpers\Values::activeBatchCodeSr())
                            <tr>
                                <td class="v-top text-strong">
                                    <a href="{{route('dashboard.employee.service_record',$employee->slug)}}" target="_blank">{{$employee->full['LFEMi']}}</a>
                                </td>
                                <td class="v-top">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 150px">Seq no:</td>
                                            <td>{{$last->sequence_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date from:</td>
                                            <td>{{Helper::dateFormat($last->from_date)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date to:</td>
                                            <td>{{$last->to_date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Item no:</td>
                                            <td>{{$last->item_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>Position:</td>
                                            <td>{{$last->position}}</td>
                                        </tr>
                                        <tr>
                                            <td>Appt. Status:</td>
                                            <td>{{$last->appointment_status}}</td>
                                        </tr>
                                        <tr>
                                            <td>Salary Type:</td>
                                            <td>{{$last->salary_type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Grade:</td>
                                            <td>{{$last->grade}}</td>
                                        </tr>
                                        <tr>
                                            <td>Step:</td>
                                            <td>{{$last->step}}</td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Basic:</td>
                                            <td>{{$last->monthly_basic}}</td>
                                        </tr>
                                        <tr>
                                            <td>Due to:</td>
                                            <td>{{$last->due_to}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="v-top">
                                    <form class="new-sr-form" id="new-sr-form-{{$employee->slug}}" data="{{$employee->slug}}">
                                        <div class="row">
                                            <x-forms.input label="Batch Code" name="batch_code" cols="3" :value="\App\Swep\Helpers\Values::activeBatchCodeSr()" readonly="readonly"/>
                                            <x-forms.input label="Date from" name="from_date" cols="3" type="date"/>
                                            <x-forms.input label="Date to (leave blank if PRESENT)" name="to_date" cols="6" type="date"/>
                                        </div>
                                        <div class="row">
                                            <x-forms.select class="item-no" label="Item no." name="item_no" cols="12" :options="[]"/>
                                            <x-forms.input  class="item-no-default" label="Item no." name="item_no_default" cols="12" :value="$last->item_no" container-class="hide-this"/>

                                        </div>
                                        <div class="row">
                                            <x-forms.select label="Appt. Status" name="appointment_status" cols="6" type="date" :value="strtoupper($employee->appointment_status)" :options="\App\Swep\Helpers\Arrays::appointmentStatus()" />
                                            <x-forms.select label="Due to" name="due_to" cols="6" type="date" :options="$serviceRecordDueTo"/>
                                        </div>
                                        <div class="row">
                                            <x-forms.select class="change-scale"  label="Salary Scale" name="salary_scale" cols="3" type="date" :options="$salaryTableScales" />
                                            <x-forms.select label="Type" name="salary_type" cols="3" type="date" :options="$salaryTypes"/>
                                            <x-forms.input class="change-scale" label="Grade" name="grade" cols="3" type="number"/>
                                            <x-forms.select class="change-scale" label="Step" name="step" cols="3" type="date" :options="\App\Swep\Helpers\Arrays::stepIncements()"/>
                                        </div>
                                        <div class="row">
                                            <x-forms.input label="Monthly Basic" name="monthly_basic" cols="4" readonly="readonly"/>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa fa-check"></i> Save</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="tab-3" role="tabpanel">
                <h4 class="tab-title">One more</h4>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor tellus eget condimentum
                    rhoncus. Aenean massa. Cum sociis natoque penatibus et magnis neque dis parturient montes, nascetur ridiculus mus.
                </p>
                <p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede
                    justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae,
                    justo.</p>
            </div>
        </div>
    </div>

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
    $salaryScale = json_encode(\App\Swep\Helpers\Arrays::salaryTable());
@endphp
@section('scripts')
    <script type="text/javascript">
        $(".update-lastest-sr-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.batch.update","slug")}}?updateLatestSr';
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

        let salaryScale = {!! $salaryScale !!};
        $("body").on("change keyup",".change-scale",function (){
            let form = $(this).parents('form');
            let grade = form.find('input[name="grade"]').val();
            let step = form.find('select[name="step"]').val();
            let scale = form.find('select[name="salary_scale"]').val();
            let mbs = 0;
            if(grade !== '' && step != "" && scale != ""){
                mbs = salaryScale[scale][grade][step];
            }else{
                mbs = 0;
            }
            form.find('input[name="monthly_basic"]').val($.number(mbs,2));
        })

        $(".item-no-default").each(function (){
            let val = $(this).val();
            let form = $(this).parents('form');
            form.find(".item-no").val(val).trigger('change');
        });


        $(".new-sr-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.batch.update","slug")}}?newSr';
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
                    toast('info','Service record added successfully','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $(".apply-many").click(function (){
            let btn = $(this);
            let ig = btn.parents('.input-group');
            let el = ig.find('.val');
            let valueToApply = el.val();
            let name = el.attr('name');
            let tab = $("#tab-1");
            let tag = el.prop('tagName');
            let forms = $(".new-sr-form");
            forms.each(function (){
                $(this).find(tag.toLowerCase()+'[name="'+name+'"]').val(valueToApply).trigger('change');
            })


        })
    </script>
@endsection