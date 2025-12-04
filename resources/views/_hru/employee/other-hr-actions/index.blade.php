@extends('adminkit.master')


@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi'] ?? ''}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position}} ({{$employee?->plantilla?->item_no}})</x-slot:subtitle>
    </x-adminkit.html.page-title>

    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#coe" data-bs-toggle="tab" role="tab" aria-selected="true">COE</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#coe-with-compensation" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">COE with Compensation</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#nosa" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">NOSA</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#nosi" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">NOSI</a></li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active show" id="coe" role="tabpanel">
                <h4 class="tab-title"><strong>Certificate of Employment</strong></h4>
                <div class="row">
                    <div class="col-md-3">
                        <form class="report_form" data="coe">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                        SIGNATORY
                                    </p>
                                    @php
                                        $signatory = \App\Models\Signatory::query()->where('type','=',13)->first();
                                        $s_name = '';
                                        $s_position = '';
                                        if(!empty($signatory)){
                                            $s_name = $signatory->employee_name;
                                            $s_position = $signatory->employee_position;
                                        }
                                    @endphp

                                    <div class="row">
                                        <x-forms.input label="Name" name="signatory_name" cols="12" :value="$s_name"/>
                                        <x-forms.input label="Position" name="signatory_position" cols="12" :value="$s_position"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success btn-sm float-end" ><i class="fa fa-refresh generate_report_btn"></i> Generate COE</button>
                                </div>
                            </div>
                            <hr>
                        </form>
                    </div>
                    <div class="col-md-9">
                        <div class="iframe-container" style="display: none">
                            <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                            <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                        </div>
                    </div>
                </div>



            </div>
            <div class="tab-pane" id="coe-with-compensation" role="tabpanel">
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="tab-title"><strong>Certificate of Employment with Compensation</strong></h4>
                        <form class="report_form" data="coec">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                        SIGNATORY
                                    </p>
                                    @php
                                        $signatory = \App\Models\Signatory::query()->where('type','=',13)->first();
                                        $s_name = '';
                                        $s_position = '';
                                        if(!empty($signatory)){
                                            $s_name = $signatory->employee_name;
                                            $s_position = $signatory->employee_position;
                                        }
                                    @endphp

                                    <div class="row">
                                        <x-forms.input label="Name" name="signatory_name" cols="12" :value="$s_name"/>
                                        <x-forms.input label="Position" name="signatory_position" cols="12" :value="$s_position"/>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success btn-sm float-end" ><i class="fa fa-refresh generate_report_btn"></i> Generate COE</button>
                                </div>
                            </div>
                        </form>
                        <hr>

                    </div>
                    <div class="col-md-9">
                        <div class="iframe-container" style="display: none">
                            <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                            <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="nosa" role="tabpanel">
                <h4 class="tab-title"><strong>Notice of Salary Adjustment</strong></h4>
                <div class="row">
                    <div class="col-md-3">
                        <form class="report_form" data="nosa">
                            @php
                                $savedNosa = $employee->otherNosa;
                                $nosa = $employee->other_hr_actions_data['nosa'] ?? [];
                            @endphp
                            <div class="row mb-2">
                                <x-forms.select label="Item and Position" name="item_and_position" id="item-and-position" cols="12" />
                                <x-forms.input container-class="hide-thiss" label="Item No" name="new_item_no" cols="4" required="required" :value="$nosa['item_no'] ?? null"/>
                                <x-forms.input container-class="hide-thiss" label="Position" name="new_position" cols="8" required="required" :value="$nosa['position'] ?? null"/>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <x-adminkit.html.alert type="info mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                        OLD Salary
                                    </x-adminkit.html.alert>
                                    <fieldset>
                                        <div class="row">
                                            <x-forms.select label="Salary Scale"  name="salary_scale" class="change-scale salary_scale" :options="\App\Swep\Helpers\Arrays::salaryTableScales()" cols="8" :value="$nosa['old']['salary_scale'] ?? null"/>
                                            <x-forms.select label="Salary Type" name="salary_type" :options="\App\Swep\Helpers\Arrays::salaryTypes()" cols="4" :value="$nosa['old']['salary_type'] ?? null"/>
                                            <x-forms.input label="Grade"  name="salary_grade" type="number" id="cur_sg" cols="4" class="change-scale grade" :value="$nosa['old']['grade'] ?? null"/>
                                            <x-forms.select  label="Step Inc" for="step" name="step_inc"  :options="\App\Swep\Helpers\Arrays::stepIncements()" cols="4" class="change-scale step" :value="$nosa['old']['step'] ?? null"/>
                                            <x-forms.input label="Monthly Salary"  name="monthly_basic" id="cur_monthly_salary" tabindex="-1" reqiured="required" cols="6" class="monthly_basic autonum-simple" :value="Helper::toNumber(Helper::sanitizeAutonum($nosa['old']['monthly_basic'] ?? null),2)"/>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <x-adminkit.html.alert type="success mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                        NEW Salary
                                    </x-adminkit.html.alert>
                                    <fieldset>
                                        <div class="row">
                                            <x-forms.select label="Salary Scale"  name="salary_scale" class="change-scale salary_scale" :options="\App\Swep\Helpers\Arrays::salaryTableScales()" cols="8" :value="$nosa['old']['salary_scale'] ?? null"/>
                                            <x-forms.select label="Salary Type" name="new_salary_type" :options="\App\Swep\Helpers\Arrays::salaryTypes()" cols="4" :value="$nosa['new']['salary_type'] ?? null"/>
                                            <x-forms.input label="Job Grade" name="new_salary_grade" cols="4" class="change-scale grade" id="new_sg" type="number" required="required" :value="$nosa['new']['grade'] ?? null"/>
                                            <x-forms.input label="Step Inc" name="new_step_inc" cols="4" class="change-scale step" id="new_si" type="number" required="required" :value="$nosa['new']['step'] ?? null"/>
                                            <x-forms.input label="Monthly Sal." name="new_monthly_salary" cols="6" class="monthly_basic autonum-simple" tabindex="-1" id="new_monthly_salary"  required="required" :value="Helper::toNumber(Helper::sanitizeAutonum($nosa['new']['monthly_basic'] ?? null),2)"/>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label> Body:
                                        <textarea class="form-control input-sm" rows="9" name="body">{{$nosa['body'] ?? null}}</textarea>
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="page-header-sm text-info mb-0 mt-2" style="border-bottom: 1px solid #cedbe1">
                                        DATES
                                    </p>
                                    <div class="row">
                                        <x-forms.input label="Header Date" name="header_date" cols="6"  type="date" :value="Carbon::now()->format('Y-m-d')"/>
                                        <x-forms.input label="Effectivity" name="effectivity" cols="6"  type="date" :value="$nosa['date_of_effectivity'] ?? null"/>
                                        <x-forms.input label="Date before effectivity" name="before_effectivity" cols="6"  type="date" :value="$nosa['date_before_effectivity'] ?? null"/>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="page-header-sm text-info mb-0 mt-2" style="border-bottom: 1px solid #cedbe1">
                                        SIGNATORY
                                    </p>

                                    <?php
                                    $signatory = \App\Models\Signatory::query()->where('type','=',0)->first();
                                    $s_name = '';
                                    $s_position = '';
                                    if(!empty($signatory)){
                                        $s_name = $signatory->employee_name;
                                        $s_position = $signatory->employee_position;
                                    }
                                    ?>
                                    <div class="row">
                                        <x-forms.input label="Name" name="signatory_name" cols="12"   :value="(isset($employee->otherNosa->values['signatory_name']) ? $employee->otherNosa->values['signatory_name'] : null) ??  (($s_name == '') ? 'ATTY. BRANDO D. NOROÑA' : $s_name)"/>


                                        <div class="col-md-12">
                                            <label>Position:</label>
                                            <textarea class="form-control input-sm" rows="3" name="signatory_position">{{(isset($employee->otherNosa->values['signatory_position']) ? $employee->otherNosa->values['signatory_position'] : null) ?? 'Deputy Administrator II
                                    Administration and Finance' }}

                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm float-end" ><i class="fa fa-refresh"></i> Generate NOSA</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <div class="col-md-9">
                        <div class="iframe-container" style="display: none">
                            <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                            <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="nosi" role="tabpanel">
                <h4 class="tab-title"><strong>Notice of Salary Increment Due to Length of Service</strong></h4>
                <div class="row">
                    <div class="col-md-3">
                        <form class="report_form" data="nosi">
                            @php
                                $nosi = $employee->other_hr_actions_data['nosi'] ?? [];
                            @endphp
                            <div class="row mb-2">
                                <x-forms.input container-class="hide-thiss" label="Item No" name="new_item_no" cols="4" required="required" :value="$nosi['item_no'] ?? null"/>
                                <x-forms.input container-class="hide-thiss" label="Position" name="new_position" cols="8" required="required" :value="$nosi['position'] ?? null"/>

                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <x-adminkit.html.alert type="info mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                        OLD Salary
                                    </x-adminkit.html.alert>
                                    <fieldset>
                                        <div class="row">
                                            <x-forms.select label="Salary Scale"  name="salary_scale" class="change-scale salary_scale" :options="\App\Swep\Helpers\Arrays::salaryTableScales()" cols="8" :value="$nosi['old']['salary_scale'] ?? null"/>
                                            <x-forms.select label="Salary Type" name="salary_type" :options="\App\Swep\Helpers\Arrays::salaryTypes()" cols="4" :value="$nosi['old']['salary_type'] ?? null"/>
                                            <x-forms.input label="Grade" name="salary_grade" type="number" id="cur_sg" cols="4" class="change-scale grade" :value="$nosi['old']['grade'] ?? null"/>
                                            <x-forms.select label="Step Inc" name="step_inc" type="number" id="cur_si" cols="4" class="change-scale step" :value="$nosi['old']['step'] ?? null" :options="\App\Swep\Helpers\Arrays::stepIncements()"/>
                                            <x-forms.input label="Monthly Salary" name="monthly_basic" id="cur_monthly_salary" tabindex="-1" reqiured="required" cols="6" class="monthly_basic autonum-simple" :value="Helper::toNumber(Helper::sanitizeAutonum($nosi['old']['monthly_basic'] ?? null),2)"/>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">
                                    <x-adminkit.html.alert type="success mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                        NEW Salary
                                    </x-adminkit.html.alert>
                                    <fieldset>
                                        <div class="row">
                                            <x-forms.select label="Salary Scale"  name="salary_scale" class="change-scale salary_scale" :options="\App\Swep\Helpers\Arrays::salaryTableScales()" cols="8" :value="$nosi['new']['salary_scale'] ?? null"/>
                                            <x-forms.select label="Salary Type" name="new_salary_type" :options="\App\Swep\Helpers\Arrays::salaryTypes()" cols="4" :value="$nosi['new']['salary_type'] ?? null"/>
                                            <x-forms.input label="Job Grade" name="new_salary_grade" cols="4" class="change-scale grade" id="new_sg" type="number" required="required" :value="$nosi['new']['grade'] ?? null"/>
                                            <x-forms.input label="Step Inc" name="new_step_inc" cols="4" class="change-scale step" id="new_si" type="number" required="required" :value="$nosi['new']['step'] ?? null"/>
                                            <x-forms.input label="Monthly Sal." name="new_monthly_salary" cols="6" class="monthly_basic autonum-simple" tabindex="-1" id="new_monthly_salary"  required="required" :value="Helper::toNumber(Helper::sanitizeAutonum($nosi['new']['monthly_basic'] ?? null),2)"/>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label> Body:
                                            <textarea class="form-control input-sm" rows="9" name="body">{{$nosi['body'] ?? null}}</textarea>
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="page-header-sm text-info mb-0 mt-2" style="border-bottom: 1px solid #cedbe1">
                                        DATES
                                    </p>
                                    <div class="row">
                                        <x-forms.input label="Header Date" name="header_date" cols="6"  type="date" :value="Carbon::now()->format('Y-m-d')"/>
                                        <x-forms.input label="Effectivity" name="effectivity" cols="6"  type="date" :value="$nosi['date_of_effectivity'] ?? null"/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p class="page-header-sm text-info mb-0 mt-2" style="border-bottom: 1px solid #cedbe1">
                                        SIGNATORY
                                    </p>

                                    <?php
                                    $signatory = \App\Models\Signatory::query()->where('type','=',0)->first();
                                    $s_name = '';
                                    $s_position = '';
                                    if(!empty($signatory)){
                                        $s_name = $signatory->employee_name;
                                        $s_position = $signatory->employee_position;
                                    }
                                    ?>
                                    <div class="row">
                                        <x-forms.input label="Name" name="signatory_name" cols="12"   :value="(isset($employee->otherNosa->values['signatory_name']) ? $employee->otherNosa->values['signatory_name'] : null) ??  (($s_name == '') ? 'ATTY. BRANDO D. NOROÑA' : $s_name)"/>


                                        <div class="col-md-12">
                                            <label>Position:</label>
                                            <textarea class="form-control input-sm" rows="3" name="signatory_position">{{(isset($employee->otherNosa->values['signatory_position']) ? $employee->otherNosa->values['signatory_position'] : null) ?? 'Deputy Administrator II
Administration and Finance' }}

                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-sm float-end" ><i class="fa fa-refresh"></i> Generate NOSI</button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <div class="col-md-9">
                        <div class="iframe-container" style="display: none">
                            <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                            <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection


@section('modals')

@endsection
@php
    $salaryTableScales = \App\Swep\Helpers\Arrays::salaryTableScales();
    $salaryScale = json_encode(\App\Swep\Helpers\Arrays::salaryTable());
@endphp
@section('scripts')
    <script type="text/javascript">
        var data = {!! \App\Swep\Helpers\Arrays::payPlantillasWithItemNumberAndDetails() !!};
        $("#item-and-position").select2({data: data});
        $('#item-and-position').on('select2:select', function (e) {
            var data = e.params.data;
            let form = $(".report_form[data='nosa']")
            form.find('input[name="new_item_no"]').val(data.id)
            form.find('input[name="new_position"]').val(data.position);
            form.find('input[name="new_salary_grade"]').val(data.salary_grade);
            form.find('input[name="new_step_inc"]').val(data.step_inc);
            $('#new_si').trigger('change');
            console.log(data);
        });



        $(".report_form").submit(function (e){
            e.preventDefault();
            let form = $(this);
            let btn = $(this).find('button[type="submit"]');
            let parentTab = $(this).parents('.tab-pane');
            let iframe = parentTab.find('iframe');
            let type = form.attr('data');
            let uri = '{{route('dashboard.employee.other_hr_actions_print',[$employee->slug,'type'])}}';
            let iframeContainer = parentTab.find('.iframe-container');
            iframeContainer.show();
            uri = uri.replace('type',type);
            uri = uri+'?'+form.serialize();
            iframe.attr('src',uri);
        });
        $(".tab-pane .print-iframe-btn").click(function (){
            let iframe = $(this).find('iframe');
            $(this).parent('.iframe-container').find('iframe').get(0).contentWindow.print();
        })

        /*
        $(".currents").change(function () {
            let cur_sg = $("#cur_sg").val();
            let cur_si = $("#cur_si").val();

            $.ajax({
                url : '{{route("dashboard.ajax.get","compute_monthly_salary")}}',
                data : {'sg' : cur_sg, 'si': cur_si},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#cur_monthly_salary").val(res);
                },
                error: function (res) {
                    console.log(res);
                }
            })
        })


        $(".news").change(function () {
            let new_sg = $("#new_sg").val();
            let new_si = $("#new_si").val();

            $.ajax({
                url : '{{route("dashboard.ajax.get","compute_monthly_salary")}}',
                data : {'sg' : new_sg, 'si': new_si},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {

                    $("#new_monthly_salary").val(res);
                },
                error: function (res) {
                    console.log(res);
                }
            })
        })
        */
        $(document).ready(function (){
            $(".currents").trigger('change');
            @if(request()->has('tab') && request('tab') != '')
                $(".nav-link[href='#{{request('tab')}}']")[0].click();
                $("#{{request('tab')}} form").submit();
            @endif
        })

        let ssl = {!! $salaryScale !!};

        $("body").on("change keyup",".change-scale",function (){
            let fieldset = $(this).parents('fieldset');
            let grade = fieldset.find('.grade').val();
            let step = fieldset.find('.step').val();
            let scale = fieldset.find('select.salary_scale').val();
            let mbs = 0;
            console.log(scale);
            if(grade !== '' && step != "" && scale != ""){
                mbs = ssl[scale][grade][step];
            }else{
                mbs = 0;
            }
            let mbsElement = fieldset.find('input.monthly_basic')[0];
            AutoNumeric.getAutoNumericElement(mbsElement).set(mbs);

            //form.find('#monthly-basic').val(mbs);
        })


    </script>
@endsection