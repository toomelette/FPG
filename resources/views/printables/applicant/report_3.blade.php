@extends('printables.print_layouts.print_layout_main')
@section('wrapper')
    <div style="font-family: Cambria">
        @if(count($grouped_applicants) > 0)
            @php($pagenum = 0)

            @include('printables.employee.header')

            <div class="row">

                <div class="col-md-12">
                    <b>LIST OF APPLICANTS</b>

                    @foreach($grouped_applicants as $key=>$applicants)

                        @php($pagenum++)
                        @if($request->headers_per_page == true && $pagenum > 1 && $request->page_break == true)
                            @include('printables.print_layouts.header_with_logo')
                            <b>LIST OF APPLICANTS</b>
                        @endif

                        @if($request->has('date_range'))
                            <br>
                            From <b>{{Carbon::parse(__sanitize::date_range($request->date_range)[0])->format('F d, Y')}}</b> to <b>{{Carbon::parse(__sanitize::date_range($request->date_range)[1])->format('F d, Y')}}</b>
                            <br>
                            <i>As of {{Carbon::now()->format('F d, Y')}}</i>
                        @endif


                        <div @if($request->page_break == true) style="break-after: page" @endif>

                            <br>
                            <b>{{$grouped_applicants[$key]['label']}}</b>
                            @if(count($filters) > 0)

                                <p style="font-size: 10px; color: red">
                                    FILTERS: [
                                    @foreach($filters as $fil=>$filter)
                                        {{$fil}} : {{str_replace('BACHELOR OF SCIENCE IN','BS',$filter)}} |
                                    @endforeach
                                    ]

                                </p>
                            @endif
                            <br>
                            <br>

                            @include('printables.applicant.tables.table-report-3')

                        </div>
                        <hr class="noPrint" style="border: 1px dashed blue !important">
                    @endforeach

                </div>
            </div>
        @else
            <br>
            <br>
            <b>No data found with your filters applied.</b>
            <br>
            <br>
            <i style="font-size: 252px; opacity: 0.2" class="fa fa-thumbs-o-down"></i>
            <br>
            <br>
            <p><i>Check your filters</i></p>
        @endif
    </div>
@endsection