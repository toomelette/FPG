@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
<div style="border: 10px solid grey;font-family: 'Times New Roman'; font-size: 16px" >
    <div style="border: 1px solid black">
        <p class="no-margin">
            CS Form No. 33-A
        </p>
        <p class="no-margin">Revised 2018</p>
        <p class="text-right">
            <i>(Stamp of Date of Receipt)</i>
        </p>
        <p class="text-center text-strong">
            Republic of the Philippines <br>
            SUGAR REGULATORY ADMINISTRATION <br>
            North Avenue, Diliman, Quezon City
        </p>
        <br>
        <p class="text-strong">
            Mr./Mrs./Ms.: <u>KRICHELLE P. SIGAYA</u>
        </p>

        <div class="text-strong" style="padding: 5px">
            <table style="width: 100%; font-size: 16px;font-weight: bold; margin-bottom: 20px">
                <tr>
                    <td style="width: 50px;"></td>
                    <td style="width: 200px"> You are hereby appointed as  </td>
                    <td class="text-center b-bottom">CHEMIST III</td>
                    <td style="width: 60px; text-underline-offset: 4px"> (JG) <u>11</u></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center"><small>(Position/Title)</small></td>
                    <td></td>
                </tr>
            </table>
            <table style="width: 100%; font-size: 16px;font-weight: bold; margin-bottom: 15px">
                <tr>
                    <td style="width: 250px;text-underline-offset: 4px">under <u>PERMANENT</u>  status at the</td>
                    <td class="b-bottom text-center">
                        Research Development & Extension Department/Agricultural Research Division/ Soils Laboratory/ Production Technology and Crop Management Section/
                        Visayas
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-center"><small>(Office/Department/Unit)</small></td>
                </tr>
            </table>
            <p style="line-height: 35px">
                with a compensation rate of <u>Forty-Seven Thousand Seven Hundred Seventy-Seven</u> (P<u>47,777.00</u>) per month.
            </p>

            <table style="width: 100%; font-size: 16px;font-weight: bold">
                <tr>
                    <td style="width: 50px"></td>
                    <td style="width: 220px"> The nature of this appointment is</td>
                    <td class="text-center b-bottom" style="width: 200px"> ORIGINAL </td>
                    <td style="width: 100px"> vise </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>(Original, Promotion, etc.)	</td>
                    <td></td>
                </tr>
            </table>
            <table style="width: 100%; font-size: 16px;font-weight: bold; margin-bottom: 20px">
                <tr>
                    <td style="width: 50px"> who</td>
                    <td class="text-center b-bottom"> RETIRED</td>
                    <td >with Plantilla Item No. <u>263</u> Page <u>14</u> . </td>
                </tr>
            </table>
            <table style="width: 100%; font-size: 16px;font-weight: bold">
                <tr>
                    <td style="width: 50px"></td>
                    <td>  This appointment shall take effect on the date of signing by the appointing officer/authority.</td>
                </tr>
            </table>
    </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            let set = 625;
            if ($("#items_table_{{$rand}}").height() < set) {
                let rem = set - $("#items_table_{{}}").height();
                $("#adjuster").css('height', rem)
                print();
            }
        })
        window.onafterprint = function () {
            window.close();
        }
    </script>
@endsection