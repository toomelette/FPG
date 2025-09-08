@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$deductionGroup}} Deductions</x-slot:title>
        <x-slot:subtitle></x-slot:subtitle>
        <x-slot:float-end>
            <button type="button" class="btn btn-primary btn-sm" data-bs-target="#show-employees-modal" id="show-employees-btn" data-bs-toggle="modal"><i class="fa fa-user"></i> Employees</button>
        </x-slot:float-end>
    </x-adminkit.html.page-title>

    <div class="row">
        <div class="col-md-2">
            <x-adminkit.html.card header-class="pb-1 pt-3">
                <div class="accordion accordion-sm mb-3">

                    @foreach($monthsArray as $year => $months)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="acc-{{$year}}">
                                @if($year == Carbon::now()->year)
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-{{$year}}" aria-expanded="true" aria-controls="filter-accordion">
                                        {{$year}}
                                    </button>
                                @else
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-body-{{$year}}" aria-expanded="false" aria-controls="filter-accordion">
                                        {{$year}}
                                    </button>
                                @endif
                            </h2>
                            <div id="acc-body-{{$year}}" class="accordion-collapse collapse {{$year == Carbon::now()->year ? 'show' : ''}}" aria-labelledby="acc-{{$year}}" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body p-0">
                                    <div style="overflow-y: scroll;" id="employee-list-container">
                                        <ul class="list-group list-group-flush" id="employee-list">
                                            @foreach($months as $month)
                                                <li class="list-group-item pt-2 pb-2 employee-item month-item" data="{{$month}}">
                                                    {{Carbon::parse($month)->format('F')}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-10">
            <x-adminkit.html.card header-class="pb-1 pt-3">
                <div id="deductions-container">

                </div>
            </x-adminkit.html.card>
        </div>
    </div>

@endsection


@section('modals')
    <x-adminkit.html.modal id="show-employees-modal" size=""/>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("body").on("click",".month-item",function (){
            let items = $(".month-item");
            items.each(function (){
                $(this).removeClass('selected');
            });
            $.ajax({
                url : '{{route("dashboard.deduction_sudemupco.index")}}?getDeductions=true',
                data : {
                    month : $(this).attr('data'),
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#deductions-container").html(res);
                },
                error: function (res) {

                }
            })
            $(this).addClass('selected');
        })

        $("body").on("click","#show-employees-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.deduction_registry.edit",$deductionGroup)}}';
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })
    </script>
@endsection