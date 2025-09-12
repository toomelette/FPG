@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Employees - Reports</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>

        <div class="row">
            <div class="col-3">
                <form id="generate-report-form">
                    <div class="row mb-2">
                        <x-forms.input label="Month" name="month" cols="6" type="month" required="required"/>
                        <x-forms.select label="Personal/Official" name="personal_official" cols="6" :options="['PERSONAL' => 'PERSONAL','OFFICIAL' => 'OFFICIAL']"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.select label="Direct/Non-Direct" name="direct_nondirect" cols="6" :options="['DIRECT' => 'DIRECT','NON-DIRECT' => 'NON-DIRECT']"/>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" id="generate_report_btn" class="float-end btn btn-success btn-sm"><i class="fa fa-refresh"></i> Generate Report</button>
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
                                        <div class="btn-group float-end">
                                            <button class="btn btn-primary btn-sm " id="print-btn"><i class="fa fa-print"></i> Print</button>
{{--                                            <a target="_blank" class="btn btn-secondary btn-sm" href="#" type="button" id="excel-btn"><i class="fa fa-file-excel"></i> Excel</a>--}}
                                        </div>
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
        $(".for_sort").sortable();
        $("#select_all_cols").change(function () {
            let t = $(this);
            if(t.prop('checked') == true){
                $(".for_sort input[type='checkbox']").each(function () {
                    let s = $(this);
                    s.prop('checked',true);
                })
            }else{
                $(".for_sort input[type='checkbox']").each(function () {
                    let s = $(this);
                    s.prop('checked',false);
                })
            }
        })
        $(".for_sort input[type='checkbox']").change(function () {
            let t = $(this);
            let check_for_all =  $("#select_all_cols");
            let all = $(".for_sort input[type='checkbox']").length;
            let checked = $(".for_sort input[type='checkbox']:checked").length;
            let diff = all - checked;
            if (diff == 0){
                check_for_all.prop('checked',true);
            }else if(diff == all){
                check_for_all.prop('checked',false);
            }else{
                check_for_all.prop('indeterminate',true);
            }

        })

        $("#generate-report-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $("#report_frame").attr('src','{{route("dashboard.permission_slip.report")}}?generate=true&'+form.serialize());
            $("#print_container").hide();
            $("#report_frame_container").hide();
            $("#report_frame_loader").fadeIn();
            remove_loading_btn(form);
            $("#excel-btn").attr('href','{{route('dashboard.employee.report_generate')}}?'+form.serialize()+'&excel=true');
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