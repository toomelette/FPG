@php
  $rand  = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')

    <div style="font-family: Cambria">
        @include('printables.print_layouts.header_accounting')
        <table style="width: 100%;">
            <tr>
                <td style="width: 75%; font-size: 28px">
                    JOURNAL ENTRY VOUCHER
                </td>
                <td>
                    <table style="width: 100%;" class="">
                        <tr>
                            <td>
                                No.:
                            </td>
                            <td class="text-strong">
                                {{$jev->jev_no}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date:
                            </td>
                            <td class="text-strong">
                                {{Helper::dateFormat($jev->date,'F d, Y')}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Book:
                            </td>
                            <td class="text-strong">
                                {{$jev->ref_book}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p class="text-center text-strong" style="font-size: 16px">ACCOUNTING ENTRIES</p>
        <table style="width: 100%;" class="tbl-padded tbl-bordered-header">
            <thead>
            <tr>
                <th rowspan="2" class="text-center">Responsibility Center</th>
                <th rowspan="2" class="text-center">Accounts and Explanation</th>
                <th rowspan="2" class="text-center">Account Code</th>
                <th colspan="2" class="text-center">Amount</th>
            </tr>
            <tr>
                <th class="text-center">Debit</th>
                <th class="text-center">Credit</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="5"><i>{{$jev->remarks}}</i></td>
            </tr>
                @forelse($jev->details as $jevDetail)
                    <tr>
                        <td>{{$jevDetail->department->name ?? '-'}}</td>
                        <td>{{$jevDetail->chartOfAccount->account_title ?? '-'}}</td>
                        <td>{{$jevDetail->account_code}}</td>
                        <td class="text-right">{{Helper::toNumber($jevDetail->jev_debit,2)}}</td>
                        <td class="text-right">{{Helper::toNumber($jevDetail->jev_credit,2)}}</td>
                    </tr>
                @empty
                @endforelse

                <tr>
                    <th colspan="3" class="text-right">
                        TOTAL
                    </th>
                    <th class="text-right">
                        {{number_format($jev->details->sum('jev_debit'),2)}}
                    </th>
                    <th class="text-right">
                        {{number_format($jev->details->sum('jev_credit'),2)}}
                    </th>
                </tr>

                @if(!empty($jev->corollaryDetails) && count($jev->corollaryDetails) > 0)
                    <tr>
                        <td colspan="5" style="height: 30px"></td>
                    </tr>
                    <tr>
                        <td colspan="5"><i>{{$jev->remarks2}}</i></td>
                    </tr>
                    @forelse($jev->corollaryDetails as $corollaryDetail)
                        <tr>
                            <td>{{$corollaryDetail->responsibilityCenter->desc ?? '-'}}</td>
                            <td>{{$corollaryDetail->chartOfAccount->account_title ?? '-'}}</td>
                            <td>{{$corollaryDetail->account_code}}</td>
                            <td class="text-right">{{Helper::toNumber($corollaryDetail->jev_debit,2)}}</td>
                            <td class="text-right">{{Helper::toNumber($corollaryDetail->jev_credit,2)}}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr>
                        <th colspan="3" class="text-right">
                            TOTAL
                        </th>
                        <th class="text-right">
                            {{number_format($jev->corollaryDetails->sum('jev_debit'),2)}}
                        </th>
                        <th class="text-right">
                            {{number_format($jev->corollaryDetails->sum('jev_credit'),2)}}
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
        <br><br>
        <div class="footer" style="width: 100%">
            <table style="width: 100%">
                <tr>
                    <td class="b-top">Prepared by:</td>
                    <td class="b-top">Approved by:</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 40px">

                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        ACCOUNT
                        <hr style="margin: 0px 10%; border-top: 1px solid black" class="no-margin">
                    </td>
                    <td class="text-center">
                        FINANCE
                        <hr style="margin: 0px 10%; border-top: 1px solid black" class="no-margin">
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        POSITION
                    </td>
                    <td class="text-center">
                        POSITION
                    </td>
                </tr>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

        {{--$(document).ready(function () {--}}
        {{--    let set = 625;--}}
        {{--    if ($("#items_table_{{}}").height() < set) {--}}
        {{--        let rem = set - $("#items_table_{{}}").height();--}}
        {{--        $("#adjuster").css('height', rem)--}}
        {{--        print();--}}
        {{--    }--}}
        {{--})--}}
        {{--window.onafterprint = function () {--}}
        {{--    window.close();--}}
        {{--}--}}
    </script>
@endsection