@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Reports</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card>
        <div class="row">
            <div class="col-3">
                <form id="generate-report-form">
                    <x-adminkit.html.accordion id="acc-fiters" class="accordion-sm mb-1" state="1">
                        <x-slot:title><i class="fa fa-filter"></i> Filters</x-slot:title>
                        <div class="row mb-2">
                            <x-forms.input label="Date From" name="df" cols="12" type="date" required="required"/>
                        </div>
                        <div class="row mb-2">
                            <x-forms.input label="Date To" name="dt" cols="12" type="date" required="required"/>
                        </div>

                    </x-adminkit.html.accordion>


                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" id="generate-report-btn" class="float-end btn btn-success btn-sm"><i class="fa fa-refresh"></i> Generate Report</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-9">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingOne">
                            <div class="accordion-button">
                                Print Preview
                            </div>
                        </div>
                        <div id="collapse2024" class="accordion-collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">

                                <div id="print_container" style="text-align: center; margin: 150px 0">
                                    <i class="fa fa-print" style="font-size: 100px; color: grey; "></i>
                                    <br>
                                    <span class="text-info">Click <b>"Generate Report"</b> button to see print preview here</span>
                                </div>


                                <div id="report_frame_loader" style="display: none">
                                    <div class="text-center pt-5 pb-5" style="font-size: 50px"><i class="fas fa-fw fa-circle-notch fa-spin"></i></div>
                                </div>
                                <div class="row" id="report_frame_container" style="height: 100%; display: none">


                                    <div class="clearfix mb-3">
                                        <button class="btn btn-primary btn-sm float-end" id="print-btn"><i class="fa fa-print"></i> Print</button>
                                    </div>
                                    <iframe id="report_frame"  style="width: 100%;overflow:hidden;" height="500" class="embed-responsive" src=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-adminkit.html.card>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#generate-report-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $("#report_frame").attr('src','{{route("dashboard.document.report_generate")}}?'+form.serialize());
            $("#print_container").hide();
            $("#report_frame_container").hide();
            $("#report_frame_loader").fadeIn();
            remove_loading_btn(form);
        })

        $("#report_frame").on("load",function () {
            remove_loading_btn($("#generate_report_form"));
            $("#report_frame_container").show();
            $("#report_frame_loader").hide();
        })

        $("#print-btn").click(function () {
            $("#report_frame").get(0).contentWindow.print();
        })

    </script>
@endsection