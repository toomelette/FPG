<div class="box box-sm box-default box-solid">
    <div class="box-header with-border">
        <p class="no-margin">PAP Code Monitoring Per Account</p>
    </div>

    <div class="box-body" style="">
        <form class="generate_report_form" id="ors_summary_form" url="{{route('dashboard.ors.report_generate','pap_code_monitoring')}}" target="#pap_monitoring_per_account_code_frame">
            <div class="row">
                {!! \App\Swep\ViewHelpers\__form2::select('pap_code',[
                    'label' => 'PAP Code:',
                    'cols' => 4,
                    'class' => 'select2_pap_code',
                    'options' => [],
                ]) !!}
                {!! \App\Swep\ViewHelpers\__form2::select('account_code',[
                    'label' => 'Account Code:',
                    'cols' => 4,
                    'class' => 'select2_account_code',
                    'options' => [],
                ]) !!}

                {!! \App\Swep\ViewHelpers\__form2::textbox('date_from',[
                    'label' => 'From',
                    'cols' => 2,
                    'type' => 'date',
                ]) !!}
                {!! \App\Swep\ViewHelpers\__form2::textbox('date_to',[
                    'label' => 'To:',
                    'cols' => 2,
                    'type' => 'date',
                ]) !!}
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-sm btn-default pull-right"><i class="fa fa-check"></i> Generate Report</button>
                </div>
            </div>
        </form>
        <hr class="no-margin">

        <div class="frame-container">
            <div class="text-center frame-placeholder" style="margin: 20% 0">
                <i class="fa fa-print text-muted" style="font-size: 94px"></i><br>
                <p class="text-muted"> Print Preview</p>
            </div>
            <div class="bs-example frame-inner-container" style="display:none;">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary pull-right print-btn" type="button"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="embed-responsive embed-responsive-16by9" style="height: 1019.938px;">
                    <iframe id="pap_monitoring_per_account_code_frame" class="embed-responsive-item" src=""></iframe>
                </div>
            </div>
        </div>
    </div>

</div>