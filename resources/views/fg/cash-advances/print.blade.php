@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <div class="text-center">
            <img src="{{asset('images/header.jpg')}}" style="height: 50px">
            <p class="no-margin">{{\App\Swep\Helpers\Get::fullAddress()}}</p>
            <p class="no-margin">Tele/Fax # (034) 434-7957 | Tel # 707-8035</p>
            <br>
            <p style="font-size: 18px" class="text-strong">REQUISITION FOR CASH ADVANCE</p>
        </div>

        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <tr>
                <td style="width: 125px;" class="inverted-dark-grey b-all">Requisitioner:</td>
                <td style="width: 55%" class="text-strong b-all">{{$ca->requested_by}}</td>
                <td style="width: 10%;"></td>
                <td class="inverted-dark-grey b-all">Date:</td>
                <td class="text-strong b-all">{{Carbon::parse($ca->date)->format('M d, Y')}}</td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td class="inverted-dark-grey b-all">Type:</td>
                <td class="text-strong b-all">{{$ca->type}}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td class="inverted-dark-grey b-all">Amount:</td>
                <td class="text-strong b-all">{{Helper::toNumber($ca->amount_requested,2)}}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td class="inverted-dark-grey b-all">Reasons:</td>
                <td colspan="4" class="b-top b-right"></td>
            </tr>
            <tr>
                <td colspan="5" class="b-vertical text-top b-bottom" style="padding: 10px 20px; height: 100px">
                    {{$ca->reason}}
                </td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 14px; margin-top: 10px" class="tbl-padded">
            <tr>
                <td class="inverted-dark-grey b-all" style="width: 30%">Requested by:</td>
                <td></td>
                <td class="inverted-dark-grey b-all" style="width: 30%">Approved by:</td>
                <td></td>
                <td class="inverted-dark-grey b-all" style="width: 30%">Released by:</td>
            </tr>
            <tr>
                <td rowspan="2" class="b-vertical text-bottom b-bottom text-center text-strong" style="padding: 10px 20px; height: 70px">
                    {{$ca->requested_by}}
                </td>
                <td rowspan="2"></td>
                <td rowspan="2" class="b-vertical text-bottom b-bottom text-center text-strong" style="padding: 10px 20px; height: 70px"></td>
                <td rowspan="2"></td>
                <td class="b-vertical text-bottom b-bottom text-center text-strong" style="padding: 10px 20px; height: 70px"></td>
            </tr>
            <tr>
                <td style="font-size: 10px" class="b-all">CASH/CHECK VOUCHER #:</td>
            </tr>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();
        window.onafterprint = function () {
            window.close();
        };
    </script>
@endsection