@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div>
        <img src="{{asset('images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
        <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
        <p class="no-margin text-left" style="font-size: 12px;"> Araneta Street, Singcang, Bacolod City</p>
        <p class="no-margin text-left" style="font-size: 10px;"> SRA Web Portal - Budget Monitoring System</p>
    </div>

    <div style="text-align: left">

        <h3 class="no-margin">Summary of Published Vacant Positions</h3>
        <p>Publication Date: <b>{{Helper::dateFormat($publication->date,'F d, Y')}}</b></p>
    </div>

    <table class="tbl tbl-bordered tbl-padded" style="width: 100%;">
        <thead>
        <tr>
            <th class="text-center" style="width: 30px">No.</th>
            <th class="text-center">Position</th>
            <th class="text-center">Item No.</th>
            <th class="text-center">No. of Applicants</th>
        </tr>
        </thead>
        <tbody>

        @forelse($publication->publicationDetails as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->position}}</td>
                <td class="text-center">{{$item->item_no}}</td>
                <td class="text-center">
                    {{\App\Swep\Helpers\Helper::toNumber(count($item->applicants),0)}}
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            print();
        })

    </script>
@endsection