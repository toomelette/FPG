@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Applicants - Reports</x-slot:title>

    </x-adminkit.html.page-title>

    <x-adminkit.html.card>
        <div class="row">
            <div class="col-3">
                <form id="generate-report-form">
                    <x-adminkit.html.accordion id="acc-fiters" class="accordion-sm mb-1" state="1">
                        <x-slot:title><i class="fa fa-filter"></i> Layout & Filters</x-slot:title>
                        <div class="row mb-2">
                            <x-forms.select label="Layout" name="layout" cols="12" :options="[
                                                'all' => 'List All' ,
                                                'by_course' => 'List by Course' ,
                                                'by_position_applied' => 'List by Position Applied',
                                                'by_item_no' => 'List by Item No.' ,
                                            ]"/>
                        </div>

                        @php
                            $db_courses = \App\Models\Applicant::select('course')->where('course','!=',null)->groupBy('course')->orderBy('course','asc')->pluck('course')->toArray();
                            $courses = ['All' => ''];
                            if(count($db_courses) > 0){
                              foreach($db_courses as $db_course){
                                $courses[$db_course] = $db_course;
                              }
                            }
                        @endphp
                        <div class="row mb-2">
                            <x-forms.select label="Course" name="course" class="select2-parent-card" cols="12" :options="$courses"/>
                        </div>
                        @php
                            $db_positions = \App\Models\ApplicantPositionApplied::select('position_applied')
                                ->where('position_applied','!=','')
                                ->where('position_applied','!=',null)
                                ->groupBy('position_applied')->orderBy('position_applied','asc')->pluck('position_applied')->toArray();
                            $positions = ['All' => ''];
                            if(count($db_positions) > 0){
                              foreach($db_positions as $db_position){
                                $positions[$db_position] = $db_position;
                              }
                            }
                        @endphp

                        <div class="row mb-2">
                            <x-forms.select label="Position applied for" name="position_applied" class="select2-parent-card" cols="12" :options="$positions"/>
                        </div>

                        @php
                            $db_items = \App\Models\HRPayPlanitilla::select('item_no','position')->orderBy('item_no','asc')->get();
                            $items = [];
                            if(!empty($db_items)){
                              foreach($db_items as $db_item){
                                $items[$db_item->item_no ] = $db_item->item_no.' - '.$db_item->position;
                              }
                            }
                        @endphp

                        <div class="row mb-2">
                            <x-forms.select label="Item No" name="item_no" class="select2-parent-card" cols="12" :options="$items"/>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="filter_date_checkbox"> Filter Date
                                        </label>
                                    </div>
                                    <label>Select date range:</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                        <input name="date_range" type="text" class="form-control  filters" id="date_range" autocomplete="off" disabled/>
                                    </div>

                                </div>
                            </div>
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
                                    @foreach($columns as $key=>$column)
                                        <li class="list-group-item">
                                            <div class="checkbox" style="margin: 0">
                                                <label>
                                                    <input checked type="checkbox" name="columns[]" value="{{$key}}"> {{$column}}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </x-adminkit.html.accordion>

                    <x-adminkit.html.accordion id="acc-more-settings" class="accordion-sm" state="0">
                        <x-slot:title><i class="fa fa-wrench"></i>  More Settings</x-slot:title>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="checkbox" style="margin: 0">
                                    <label>
                                        <input type="checkbox" name="page_break" value="page_break"> Add page breaks
                                    </label>
                                </div>

                                <div class="checkbox" style="margin: 0">
                                    <label>
                                        <input type="checkbox" name="headers_per_page" value="headers_per_page"> Include headers per table
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
        $('#date_range').daterangepicker();
        $('#date_range').attr('disabled','disabled');

        $("#filter_date_checkbox").change(function () {
            if($(this).prop('checked') == true){
                $('#date_range').removeAttr('disabled');s
            }else{
                $('#date_range').attr('disabled','disabled');
            }
        });

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

        $("#generate-report-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $("#report_frame").attr('src','{{route("dashboard.applicant.report_generate")}}?'+form.serialize());
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