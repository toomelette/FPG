@extends('adminkit.master')


@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Plantilla - Reports</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card>

        <div class="row">
            <div class="col-3">
                <form id="generate-report-form">
                    <x-adminkit.html.accordion id="acc-fiters" class="accordion-sm mb-1" state="1">
                        <x-slot:title><i class="fa fa-filter"></i> Layout</x-slot:title>
                        <div class="row mb-2">
                            <x-forms.select label="Layout" name="type" cols="12" :options="[
                                            '' => 'List all',
                                            'department' => 'By department',
                                            'job_grade' => 'By Job Grade',
                                            'location' => 'By Location',
                                        ]"/>
                        </div>
                    </x-adminkit.html.accordion>
                    <x-adminkit.html.accordion id="acc-sort" class="accordion-sm" state="0">
                        <x-slot:title><i class="fa fa-sort-alpha-asc fw"></i>  Data Sorting</x-slot:title>
                        <div class="row mb-2">
                            <x-forms.select label="Column to sort" name="order_column" cols="6"  :options="[
                                                    'item_no' => 'Item No.',
                                                    'job_grade' => 'Job Grade',
                                                    'position' => 'Position Title',
                                                ]"/>
                            <x-forms.select label="Direction" name="direction" cols="6"  :options="['asc' => 'Ascending','desc' => 'Descending',]"/>
                        </div>
                    </x-adminkit.html.accordion>

                    <x-adminkit.html.accordion id="acc-columns" class="accordion-sm" state="0">
                        <x-slot:title><i class="fa fa-columns"></i> Select columns to show</x-slot:title>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox" style="margin: 0">
                                    <label>
                                        <input type="checkbox"  id="select_all_cols"> Select/Deselect all
                                    </label>
                                </div>
                                <br>
                                Select columns to show: <span class="text-info text-strong pull-right">(Drag to reorder)</span>
                                <ul class="for_sort list-group list-group-flush">
                                    @if(count(\App\Swep\Helpers\Arrays::plantillaColumnsForReport()) > 0)
                                        @foreach(\App\Swep\Helpers\Arrays::plantillaColumnsForReport() as $column_name => $display_name)
                                            <li class="list-group-item">
                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <input {{($display_name['checked'] == 1)? 'checked=""' : ''}} type="checkbox" name="columns[]" value="{{$column_name}}"> {{$display_name['name']}}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </x-adminkit.html.accordion>

                    <x-adminkit.html.accordion id="acc-more-settings" class="accordion-sm" state="0">
                        <x-slot:title><i class="fa fa-wrench"></i>  More Settings</x-slot:title>
                        <div class="row mb-2">
                            <div class="col-5">
                                <x-forms.select label="Font" name="font" cols="12"  :options="\App\Swep\Helpers\Arrays::fonts()"/>
                                <x-forms.select label="Size" name="font_size" cols="12"  :options="\App\Swep\Helpers\Arrays::fontSizes()"/>
                            </div>
                            <div class="col-7">
                                <div class="checkbox" style="margin: 0">
                                    <label>
                                        <input type="checkbox" name="include_empty_field" value="include_empty_field"> Include empty field (end)
                                    </label>
                                </div>
                                <div class="checkbox" style="margin: 0">
                                    <label>
                                        <input type="checkbox" name="separate_page_per_table" value="separate_page_per_table"> Separate page per table
                                    </label>
                                </div>

                                <div class="checkbox" style="margin: 0">
                                    <label>
                                        <input type="checkbox" name="headers_per_table" value="headers_per_table"> Include headers per table
                                    </label>
                                </div>
                            </div>
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
            $("#report_frame").attr('src','{{route("dashboard.plantilla.report_generate")}}?'+form.serialize());
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