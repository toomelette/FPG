@extends('printables.print_layouts.print_layout_main')

@section('wrapper')


    @if(count($grouped_applicants) > 0)
        @include('printables.print_layouts.header_with_logo')
        @php($pagenum = 0)

        <div class="row">

            <div class="col-md-12">
                <b>LIST OF APPLICANTS</b>

                    @foreach($grouped_applicants as $key=>$applicants)
                        @php($num = 1)
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


                        <div class="row" @if($request->page_break == true) style="break-after: page" @endif>

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
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead class="">
                                    <tr class="text-strong">
                                        @foreach($requested_columns as $requested_column)
                                            @switch($requested_column)
                                                @case('numbering')
                                                    <th class="{{$requested_column}}">#</th>
                                                @break
                                                @default
                                                    <th class="{{$requested_column}}">{{$columns[$requested_column]}}</th>
                                                @break
                                            @endswitch
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($applicants as $applicant_slug=>$applicant)
                                            @if(is_array($applicant))
                                                <tr>
                                                    @foreach($requested_columns as $requested_column)
                                                        @switch($requested_column)
                                                            @case('numbering')
                                                                <td class="{{$requested_column}}">{{$num++}}</td>
                                                            @break
                                                            @case('fullname')
                                                                <td class="{{$requested_column}}">{{$applicant['applicant_obj']->lastname}}, {{$applicant['applicant_obj']->firstname}}</td>
                                                            @break
                                                            @case('course')
                                                                @if(!empty($applicant['applicant_obj']->course))
                                                                    <td class="{{$requested_column}}">{{str_replace('BACHELOR OF SCIENCE IN','BS',$applicant['applicant_obj']->course)}}</td>
                                                                @else
                                                                    <td class="{{$requested_column}}">N/A</td>
                                                                @endif
                                                            @break
                                                            @case('department_unit')
                                                                @if(!empty($applicant['applicant_obj']->departmentUnit))
                                                                    <td class="{{$requested_column}}">{{$applicant['applicant_obj']->departmentUnit->description}}</td>
                                                                @else
                                                                    <td class="{{$requested_column}}">N/A</td>
                                                                @endif
                                                            @break
                                                            @case('date_of_birth')
                                                                <td class="{{$requested_column}}">{{date('M. d, Y',strtotime($applicant['applicant_obj']->date_of_birth))}}</td>
                                                            @break
                                                            @case('position_applied')
                                                                @if(!empty($applicant['applicant_obj']->positionApplied))
                                                                    <td class="{{$requested_column}}">

                                                                        @foreach($applicant['applicant_obj']->positionApplied as $position_applied)
                                                                           • {{$position_applied->position_applied}}<br>
                                                                        @endforeach

                                                                    </td>
                                                                @else
                                                                    <td class="{{$requested_column}}">N/A</td>
                                                                @endif
                                                            @break
                                                            @case('received_at')
                                                                <td class="{{$requested_column}}">{{date("m/d/Y",strtotime($applicant['applicant_obj']->received_at))}}</td>
                                                            @break
                                                            @default
                                                                <td class="{{$requested_column}}">{{$applicant['applicant_obj']->$requested_column}}</td>
                                                            @break
                                                        @endswitch

                                                    @endforeach

                                                </tr>
                                            @endif

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
@endsection