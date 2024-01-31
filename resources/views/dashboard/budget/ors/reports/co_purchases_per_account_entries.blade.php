<div class="box box-sm box-default box-solid">
    <div class="box-header with-border">
        <p class="no-margin">CO Purchases per account</p>
    </div>

    <div class="box-body" style="">
        <form class="generate_report_form" id="co_purchases_per_account_entries_form" url="{{route('dashboard.ors.report_generate','co_purchases_per_account_entries')}}" target="#co_purchases_per_account_entries_frame">
            <div class="row">

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
                        <div class="btn-group pull-right">
                            <button class="btn btn-sm btn-default generate_excel_btn hidden" type="button"><i class="fa fa-file-excel-o"></i> Excel</button>
                            <button class="btn btn-sm btn-primary print-btn" type="button"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </div>
                <div class="embed-responsive embed-responsive-16by9" style="height: 1019.938px;">
                    <iframe id="co_purchases_per_account_entries_frame" class="embed-responsive-item" src=""></iframe>
                </div>
            </div>
        </div>
    </div>

</div>