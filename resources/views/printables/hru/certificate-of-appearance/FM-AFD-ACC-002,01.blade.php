
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        .bg-box {
            width: 210mm;
            height: 148.5mm;
            background-image: url('{{ asset('images/ca-bg.jpg') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            padding: 7mm;
            box-sizing: border-box;
            font-family: Arial;
            font-size: 16px;
        }
        table{
            font-size: 16px;
        }
    </style>
    @for($x = 0; $x < 2; $x++)
        <div class="bg-box">
            <div style="padding-top: 45mm;">
                <b>TO WHOM IT MAY CONCERN:</b>
                <div style="padding-left: 3mm">
                    <table style="width: 100%" class="tbl-padded">
                        <tr>
                            <td style="width: 58mm">This is to certify that Mr./Ms.</td>
                            <td class="b-bottom text-strong">GERALD JESTER S. GUANCE</td>
                            <td style="width: 2mm;"></td>
                            <td class="b-bottom" style="width: 45mm; font-family: 'Arial Narrow'">COMPUTER PROGRAMMER III</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center"><small>Position</small></td>
                        </tr>
                    </table>
                    <table style="width: 100%" class="tbl-padded">
                        <tr>
                            <td style="width: 35mm">has appeared at</td>
                            <td class="b-bottom">PPSPD, SRA Quezon City</td>
                        </tr>
                        <tr>
                            <td>Purpose:</td>
                            <td class="b-bottom">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</td>
                        </tr>
                        <tr>
                            <td>Period:</td>
                            <td class="b-bottom"></td>
                        </tr>
                    </table>
                    <br>
                    <p class="text-strong" style="font-size: 14px">This is to certify that the following is/are provided by the issuing office/personnel.</p>
                    <table style="width: 100%;" class="tbl-padded">
                        <tr>
                            <td style="width: 40%; vertical-align: top">
                                <table style="font-size: 14px">
                                    <tr>
                                        <td class="b-bottom" style="width: 5mm"></td>
                                        <td>Breakfast</td>
                                    </tr>
                                    <tr>
                                        <td class="b-bottom"></td>
                                        <td>Lunch</td>
                                    </tr>
                                    <tr>
                                        <td class="b-bottom"></td>
                                        <td>Dinner</td>
                                    </tr>
                                    <tr>
                                        <td class="b-bottom"></td>
                                        <td>Lodging</td>
                                    </tr>
                                    <tr>
                                        <td class="b-bottom"></td>
                                        <td>None of the above</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="text-center" style="font-size: 14px">
                                    <tr>
                                        <td class="text-strong" style="padding-top: 8mm"><u>DIGNA D. GONZALES</u></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 2mm">(Signature over Printed Name)</td>
                                    </tr>
                                    <tr>
                                        <td class="text-strong"><u>DEPARTMENT MANGER III, PPSPD</u></td>
                                    </tr>
                                    <tr>
                                        <td>(Position/Designation)</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="font-size: 8px; text-align: right; padding-right: 20mm">
                    FM-AFD-ACC-002, Rev.01 <br>
                    Effectivity Date: February 2, 2026
                </div>
            </div>
        </div>
    @endfor



@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            //print();
        })

    </script>
@endsection