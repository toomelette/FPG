@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <tr>
                <td style="width: 80%;">
                    <p class="no-margin text-strong" style="font-size: 28px">{{\App\Swep\Helpers\Get::company()}}</p>
                    <p class="no-margin" style="font-size: 18px">{{\App\Swep\Helpers\Get::address()}}</p>
                </td>
                <td>
                    <table style="width: 100%; font-size: 14px">
                        <tr>
                            <td>SI Date:</td>
                            <td>{{Helper::dateFormat($si->date,'M. d, Y')}}</td>
                        </tr>
                        <tr>
                            <td>SI No:</td>
                            <td>{{$si->invoice_no}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px"></td>
            </tr>
            <tr>
                <td class="text-strong b-all">{{$si->client->name}} - {{$si->client->account_no}}</td>
            </tr>
            <tr>
                <td style="height: 10px"></td>
            </tr>
            <tr>
                <td class="b-all">{{$si->client->address}}</td>
            </tr>
        </table>
        <p class="text-strong" style=" margin-top: 15px">PROJECT PREPARATION</p>
        @include('fg.sales-invoice.print-table-preparations')
        <br>
        <p class="text-strong">PROJECT EXPENSES</p>
        @include('fg.sales-invoice.print-table-expenses')
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();
    </script>
@endsection