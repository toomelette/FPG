@extends('adminkit.master')


@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi'] ?? ''}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position}}</x-slot:subtitle>
    </x-adminkit.html.page-title>

    <div class="tab tab-vertical">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="#vertical-icon-tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">
                    Certificate of Employment
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="#vertical-icon-tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                    COE with Compensation
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="#vertical-icon-tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                    NOSA
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="#vertical-icon-tab-4" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                    NOSI
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="vertical-icon-tab-1" role="tabpanel">
                <h4 class="tab-title"><strong>Certificate of Employment</strong></h4>
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
                                <x-forms.input label="Name" name="signatory_name" cols="6" :value="$s_name"/>
                                <x-forms.input label="Position" name="signatory_position" cols="6" :value="$s_position"/>
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
                <div class="iframe-container" style="display: none">
                    <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                    <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                </div>
            </div>
            <div class="tab-pane" id="vertical-icon-tab-2" role="tabpanel">
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
                                <x-forms.input label="Name" name="signatory_name" cols="6" :value="$s_name"/>
                                <x-forms.input label="Position" name="signatory_position" cols="6" :value="$s_position"/>
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
                <div class="iframe-container" style="display: none">
                    <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                    <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                </div>
            </div>
            <div class="tab-pane" id="vertical-icon-tab-3" role="tabpanel">
                <h4 class="tab-title"><strong>Notice of Salary Adjustment</strong></h4>
                <form class="report_form" data="nosa">


                    @php
                        $savedNosa = $employee->otherNosa;

                    @endphp
                    <div class="row">
                        <div class="col-md-4">
                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                CURRENT
                            </p>
                            <div class="row">
                                <x-forms.input label="Job Grade" name="salary_grade" type="number" id="cur_sg" cols="4" class="currents" :value="(isset($employee->otherNosa->values['salary_grade']) ? $employee->otherNosa->values['salary_grade'] : null) ?? $employee"/>
                                <x-forms.input label="Step Inc" name="step_inc" type="number" id="cur_si" cols="4" class="currents" :value="(isset($employee->otherNosa->values['step_inc']) ? $employee->otherNosa->values['step_inc'] : null) ?? $employee"/>
                                <x-forms.input label="Monthly Sal." name="monthly_basic" id="cur_monthly_salary" tabindex="-1" reqiured="required" cols="4" class="currents" :value="Helper::toNumber(Helper::sanitizeAutonum(isset($employee->otherNosa->values['monthly_basic']) ? $employee->otherNosa->values['monthly_basic'] : null),2)"/>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <p class="page-header-sm text-info" style="border-bottom: 1px solid green; color: green">
                                NEW
                            </p>
                            <div class="row">
                                <x-forms.input label="Item No" name="new_item_no" cols="2" required="required" :value="(isset($employee->otherNosa->values['new_item_no']) ? $employee->otherNosa->values['new_item_no'] : null) ?? null"/>
                                <x-forms.input label="Position" name="new_position" cols="4" required="required" :value="(isset($employee->otherNosa->values['new_position']) ? $employee->otherNosa->values['new_position'] : null) ?? null"/>
                                <x-forms.input label="Job Grade" name="new_salary_grade" cols="2" class="news" id="new_sg" type="number" required="required" :value="(isset($employee->otherNosa->values['new_salary_grade']) ? $employee->otherNosa->values['new_salary_grade'] : null) ?? null"/>
                                <x-forms.input label="Step Inc" name="new_step_inc" cols="2" class="news" id="new_si" type="number" required="required" :value="(isset($employee->otherNosa->values['new_step_inc']) ? $employee->otherNosa->values['new_step_inc'] : null) ?? null"/>
                                <x-forms.input label="Monthly Sal." name="new_monthly_salary" cols="2" class="news" tabindex="-1" id="new_monthly_salary"  required="required" :value="Helper::toNumber(Helper::sanitizeAutonum(isset($employee->otherNosa->values['new_monthly_salary']) ? $employee->otherNosa->values['new_monthly_salary'] : null),2)"/>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                DATES
                            </p>
                            <div class="row">
                                <x-forms.input label="Effectivity" name="effectivity" cols="6"  type="date" :value="(isset($employee->otherNosa->values['effectivity']) ? $employee->otherNosa->values['effectivity'] : null) ?? null"/>
                                <x-forms.input label="As of" name="as_of" cols="6"  type="date" :value="(isset($employee->otherNosa->values['as_of']) ? $employee->otherNosa->values['as_of'] : null) ?? null"/>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
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
                                <x-forms.input label="Name" name="signatory_name" cols="6"   :value="(isset($employee->otherNosa->values['signatory_name']) ? $employee->otherNosa->values['signatory_name'] : null) ??  (($s_name == '') ? 'ATTY. BRANDO D. NOROÑA' : $s_name)"/>


                                <div class="col-md-6">
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
                <div class="iframe-container" style="display: none">
                    <button class="btn btn-sm btn-outline-secondary float-end print-iframe-btn mb-2"><i class="fa fa-print"></i> Print</button>
                    <iframe class="embed-responsive-item" style="border: 1px solid lightgrey; width: 100%;" src="" height="600"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
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
    </script>
@endsection