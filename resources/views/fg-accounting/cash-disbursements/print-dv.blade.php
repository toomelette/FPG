@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\RECORDS\DocumentRequests $documentRequest **/
@endphp
@extends('printables.print_layouts.print_layout_main')
@section('wrapper')
    <div style="font-family: Cambria">
        <table style="width: 100%; font-size: 14px">
            <tr>
                <td style="width: 65%;">
                    <h3 class="no-margin text-strong">Fil Power Group & Marketing Corp.</h3>
                    <p class="no-margin">Lopez Jaena Street, Bacolod City</p>
                </td>
                <td class="text-right text-strong">
                    <i>ORIGINAL</i>
                </td>
            </tr>
            <tr>
                <td>
                    <h3 class="text-strong">DISBURSEMENT VOUCHER</h3>
                    <table style="width: 100%; font-size: 14px; border-spacing: 5px;border-collapse: separate;" class="tbl-padded">
                        <tr>
                            <td>PAYEE</td>
                            <td style="border: 1px solid black">{{$journal->counterparty}}</td>
                        </tr>
                        <tr>
                            <td>EXPLANATION</td>
                            <td style="border: 1px solid black">{{$journal->remarks}}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%; font-size: 14px; border-spacing: 5px;border-collapse: separate;" class="tbl-padded">
                        <tr>
                            <td>DATE</td>
                            <td style="border: 1px solid black">{{Helper::dateFormat($journal->date,'M. d, Y')}}</td>
                        </tr>
                        <tr>
                            <td>VOUCHER NO.</td>
                            <td style="border: 1px solid black">{{$journal->control_no}}</td>
                        </tr>
                        <tr>
                            <td>DRAWEE BANK.</td>
                            <td style="border: 1px solid black">{{$journal->bank}}</td>
                        </tr>
                        <tr>
                            <td>CHECK NO</td>
                            <td style="border: 1px solid black">{{$journal->check_no}}</td>
                        </tr>
                        <tr>
                            <td>CHECK AMT.</td>
                            <td style="border: 1px solid black">{{Helper::toNumber($journal->check_amount)}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-bottom">ACCOUNT CODE</th>
                <th class="text-center b-bottom">ACCOUNT TITLE</th>
                <th class="text-center b-bottom">DEBIT</th>
                <th class="text-center b-bottom">CREDIT</th>
            </tr>
            </thead>
            <tbody>
            @forelse($journal->entries as $entry)
                <tr>
                    <td>{{$entry->account_code}}</td>
                    <td>{{$entry->chartOfAccount->account_title}}</td>
                    <td class="text-right">{{Helper::toNumber($entry->debit)}}</td>
                    <td class="text-right">{{Helper::toNumber($entry->credit)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th class="b-top" colspan="2">TOTAL</th>
                <th class="b-top text-right">
                    {{Helper::toNumber($journal->entries->sum('debit'))}}
                </th>
                <th class="b-top text-right">
                    {{Helper::toNumber($journal->entries->sum('credit'))}}
                </th>
            </tr>
            </tbody>
        </table>

        <br>
        <table style="width: 100%; font-size: 14px; border-collapse: separate;border-spacing: 10px">
            <tr>
                <td style="width: 20%;" class="text-top">
                    Prepared by:
                </td>
                <td style="width: 20%;" class="text-top">
                    Checked by:
                </td>
                <td style="width: 20%;" class="text-top">
                    Approved by:
                </td>
                <td style="width: 40%;" rowspan="2" class="text-top">
                    <small>
                        Received from Fil Power Group & Marketing Corp. the sum of {{strtoupper(Helper::numberToWords($journal->check_amount))}} ONLY
                    </small>
                </td>
            </tr>
            <tr>
                <td class="b-bottom"><br><br></td>
                <td class="b-bottom"></td>
                <td class="b-bottom"></td>
            </tr>

            <tr>
                <td>LHYCA DIAMANTE</td>
                <td>A.B. GUEVARA</td>
                <td>R.L. BERMEO JR.</td>
                <td class="b-bottom"></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="text-center">SIGNATURE OVER PRINTED NAME</td>
            </tr>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();

    </script>
@endsection