@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        @media print {
            @page {
                size: Letter portrait; /* or portrait */
            }
        }
    </style>
    <div style="font-family: Cambria">
        <div class="no-print">
            <div class="row" style="padding: 15px 15px 0px 15px">
                <x-forms.input label="Name on Check" name="name" class="editable" cols="4" :value="$journal->counterparty"/>
                <x-forms.input label="Date" name="date" cols="2" class="editable" type="date" :value="$journal->date"/>
            </div>
            <div class="row" style="padding: 0px 15px 20px 15px">
                <div class="col-md-1">
                    <button class="btn btn-primary" onclick="print()">Print</button>
                </div>
            </div>
        </div>
        <div class="printable" style="width: 204mm;">
            <table style="width: 100%" class="">
                <tr>
                    <td class="text-center" style="width: 146mm; height: 5mm"></td>
                    <td class="text-center" style="width: 5mm; height: 5mm" id="m1">M</td>
                    <td class="text-center" style="width: 5mm; height: 5mm" id="m2">M</td>
                    <td class="text-center" style="width: 2mm; height: 5mm">-</td>
                    <td class="text-center" style="width: 5mm; height: 6mm" id="d1">D</td>
                    <td class="text-center" style="width: 5mm; height: 6mm" id="d2">D</td>
                    <td class="text-center" style="width: 3mm; height: 5mm">-</td>
                    <td class="text-center" style="width: 5mm; height: 5mm" id="y1">Y</td>
                    <td class="text-center" style="width: 5mm; height: 5mm" id="y2">Y</td>
                    <td class="text-center" style="width: 5mm; height: 5mm" id="y3">Y</td>
                    <td class="text-center" style="width: 5mm; height: 5mm" id="y4">Y</td>
                    <td></td>
                </tr>
            </table>
            <table style="width: 100%; font-size: 16px;margin-top: 11px">
                <tr>
                    <td style="width: 20mm; height: 7mm"></td>
                    <td style="width: 112mm; height: 7mm" class="text-strong"><span id="name">{{$journal->counterparty}}</span></td>
                    <td style="width: 10mm; height: 7mm"></td>
                    <td style="width: 50mm; height: 7mm" class="text-strong">
                        {{Helper::toNumber($journal->check_amount)}}
                    </td>
                    <td></td>
                </tr>
            </table>

            <table style="width: 100%; font-size: 14px; margin-top: 5px">
                <tr>
                    <td style="width: 12mm; height: 7mm"></td>
                    <td style="width: 112mm; height: 7mm">
                        {{Str::upper(Helper::numberToWords($journal->check_amount))}} ONLY
                    </td>
                    <td></td>
                </tr>
            </table>

        </div>
    </div>

    <x-adminkit.html.modal-template id="edit-modal" size="sm" form-id="edit-form">
        <x-slot:title></x-slot:title>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("body").on('change keyup','.editable',function (){
            let currentVal = $(this).val();
            let targetId = $(this).attr('name');
            if($(this).attr('type') === 'date'){
                currentVal = moment(currentVal).format('MM-DD-YYYY')
                currentVal = currentVal.split('');
                $("#m1").html(currentVal[0]);
                $("#m2").html(currentVal[1]);
                $("#d1").html(currentVal[3]);
                $("#d2").html(currentVal[4]);
                $("#y1").html(currentVal[6]);
                $("#y2").html(currentVal[7]);
                $("#y3").html(currentVal[8]);
                $("#y4").html(currentVal[9]);
            }else{
                $(".printable").find('span#'+targetId).html(currentVal)
            }
        });

        $(document).ready(function (){
            $(".editable").trigger('change');
        })
    </script>
@endsection