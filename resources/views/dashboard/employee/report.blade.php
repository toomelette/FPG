@extends('layouts.admin-master')

@section('content')


    <section class="content">
        <div class="box box-default">

            <div class="box-header with-border">
                <i class="fa fa-print"></i>

                <h3 class="box-title">Report</h3>
            </div>


            <div class="box-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="well well-sm">


                            <form id="generate_report_form">

                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::select('type',[
                                        'label' => 'Layout:',
                                        'cols' => 12,
                                        'options' => [
                                            '' => 'List all',
                                            'sex' => 'By sex',
                                            'unit' => 'By Unit',
                                            'address' => 'By Residential Address',
                                            'position' => 'By position',
                                            'locations' => 'By location',
                                            'salary_grade' => 'By salary grade',
                                            'civil_status' => 'By civil status',
                                        ],
                                        'class' => 'input-sm',
                                    ]) !!}
                                </div>


                                <div class="box box-sm box-default box-solid">
                                    <div class="box-header with-border">
                                        <p class="box-title-sm no-margin"><i class="fa fa-filter"></i> Filters</p>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body" style="display: block">
                                        <div class="row">
                                            {!! \App\Swep\ViewHelpers\__form2::select('status',[
                                                'label' => 'Status:',
                                                'cols' => 6,
                                                'options' => \App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeStatus(),'option','value'),
                                                'class' => 'input-sm',
                                                'required' => 'required',
                                            ]) !!}


                                            {!! \App\Swep\ViewHelpers\__form2::select('sex',[
                                                'label' => 'Sex:',
                                                'cols' => 6,
                                                'options' => [
                                                    'MALE' => 'MALE',
                                                    'FEMALE' => 'FEMALE',
                                                ],
                                                'class' => 'input-sm',
                                            ]) !!}

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Location:</label>
                                                    <div class="checkbox">
                                                        @foreach(\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeGroupings(),'option','value') as $key=>$value)
                                                        <label>
                                                            <input type="checkbox" name="locations[]" value="{{$value}}" checked> {{$key}}
                                                        </label>
                                                            <br>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Civil Status:</label>
                                                    <div class="checkbox">
                                                        @foreach(\App\Swep\Helpers\Helper::civil_status() as $key=>$value)
                                                            <label>
                                                                <input type="checkbox" name="civil_status[]" value="{{$key}}" checked> {{$value}}
                                                            </label>
                                                            <br>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

{{--                                            {!! \App\Swep\ViewHelpers\__form2::select('civil_status',[--}}
{{--                                                'label' => 'Civil Status:',--}}
{{--                                                'cols' => 6,--}}
{{--                                                'options' => ,--}}
{{--                                                'class' => 'input-sm',--}}
{{--                                            ]) !!}--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="box box-sm box-default box-solid collapsed-box">
                                    <div class="box-header with-border">
                                        <p class="box-title-sm no-margin"><i class="fa fa-sort-alpha-asc"></i> Data sorting</p>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body" style="display: none">
                                        <div class="row">
                                            {!! \App\Swep\ViewHelpers\__form2::select('order_column',[
                                                'label' => 'Column to sort:',
                                                'cols' => 6,
                                                'options' => [
                                                    'lastname' => 'Lastname',
                                                    'firstname' => 'Firstname',
                                                    'sex' => 'Sex',
                                                    'salary_grade' => 'Salary Grade',
                                                    'employee_no' => 'Employee No.',
                                                    'position' => 'Position',
                                                    'monthly_basic' => 'Monthly Basic',
                                                    'date_of_birth' => 'Date of Birth',
                                                    'dept_name' => 'Department',
                                                ],
                                                'class' => 'input-sm',
                                            ]) !!}
                                            {!! \App\Swep\ViewHelpers\__form2::select('direction',[
                                                'label' => 'Direction:',
                                                'cols' => 6,
                                                'options' => [
                                                    'asc' => 'Ascending',
                                                    'desc' => 'Descending',
                                                ],
                                                'class' => 'input-sm',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="box box-sm box-default box-solid collapsed-box">
                                    <div class="box-header with-border">
                                        <p class="box-title-sm no-margin"><i class="fa fa-columns"></i> Select Columns to show</p>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body" style="display: none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="checkbox" style="margin: 0">
                                                    <label>
                                                        <input type="checkbox"  id="select_all_cols"> Select/Deselect all
                                                    </label>
                                                </div>
                                                <br>
                                                Select columns to show: <span class="text-info text-strong pull-right">(Drag to reorder)</span>
                                                <ol class="for_sort sortable todo-list">
                                                    @if(count($allColumnsForReport) > 0)
                                                        @foreach($allColumnsForReport as $column_name => $display_name)
                                                            <li class="ui-sortable">
                                                                <div class="checkbox" style="margin: 0">
                                                                    <label>
                                                                        <input {{($display_name['checked'] == 1)? 'checked=""' : ''}} type="checkbox" name="columns[]" value="{{$column_name}}"> {{$display_name['name']}}
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @endif

                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-sm box-default box-solid collapsed-box">
                                    <div class="box-header with-border">
                                        <p class="box-title-sm no-margin"><i class="fa fa-wrench"></i> More settings (Font, font size, page breaks, etc.)</p>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body" style="display: none">
                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="row">
                                                    {!! \App\Swep\ViewHelpers\__form2::select('font',[
                                                        'label' => 'Font:',
                                                        'cols' => 12,
                                                        'options' => \App\Swep\Helpers\Arrays::fonts(),
                                                        'class' => 'input-sm',
                                                    ]) !!}
                                                </div>
                                                <div class="row">
                                                    {!! \App\Swep\ViewHelpers\__form2::select('font_size',[
                                                        'label' => 'Size:',
                                                        'cols' => 12,
                                                        'options' => \App\Swep\Helpers\Arrays::fontSizes(),
                                                        'class' => 'input-sm',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-7">
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
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" id="generate_report_btn" class="pull-right btn btn-success"><i class="fa fa-refresh"></i> Generate Report</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <span style="font-weight: bold; font-size: 16px">Print Preview</span>
                                <button id="print_btn" class="btn btn-success btn-sm pull-right"><i class="fa fa-print"></i> Print</button>
                            </div>
                            <div class="panel-body" style="height: 700px">
                                <div id="print_container" style="text-align: center; margin-top: 100px">
                                    <i class="fa fa-print" style="font-size: 300px; color: grey; "></i>
                                    <br>
                                    <span class="text-info">Click <b>"Generate Report"</b> button to see print preview here</span>
                                </div>


                                <div id="report_frame_loader" style="display: none">
                                    <center>
                                        <img style="width: 100px; margin: 140px 0;" src="{{asset('images/loader.gif')}}">
                                    </center>
                                </div>
                                <div class="row" id="report_frame_container" style="height: 100%; display: none">


                                    <div class="col-md-12" style="height: 100%">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="report_frame"  style="width: 100%; height: 100%;overflow:hidden; " class="embed-responsive" src=""></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $(".for_sort").sortable();

        $("#generate_report_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $("#report_frame").attr('src','{{route("dashboard.employee.report_generate")}}?'+form.serialize());
            $("#print_container").hide();
            $("#report_frame_container").hide();
            $("#report_frame_loader").fadeIn();
        })

        $("#report_frame").on("load",function () {
            remove_loading_btn($("#generate_report_form"));
            $("#report_frame_container").show();
            $("#report_frame_loader").hide();
        })

        $("#print_btn").click(function () {
            $("#report_frame").get(0).contentWindow.print();
        })

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
    </script>



@endsection