<p class="text-left small-margin" style="margin-right: 10px; font-style: italic; font-size: 10px"><b>CSC Form 48</b></p>
<p class="text-center" style="margin: 5px"><b>SUGAR REGULATORY ADMINISTRATION</b></p>
<p class="text-center" style="margin: 5px"><b>DAILY TIME RECORD</b></p>
<br>
<p class="small-margin" style="font-size: 16px"><b>{{strtoupper($employee->lastname)}}, {{strtoupper($employee->firstname)}} {{strtoupper($employee->name_ext)}}</b></p>
<p class="small-margin">For the month of <b>{{\Carbon\Carbon::parse($month)->format('F Y')}}</b> </p>
<table class="table table-bordered table-condensed dtr-table" style="font-size: 11.5px">
    <thead>
    <tr>
        <th rowspan="2">Date</th>
        <th colspan="2">Morning</th>
        <th colspan="2">Afternoon</th>
        <th colspan="2">Overtime</th>
        <th rowspan="2" style="min-width: 30px">Late</th>
        <th rowspan="2" style="min-width: 30px">U/T</th>
        <th rowspan="2">Remarks</th>
    </tr>
    <tr>
        <th style="min-width: 30px">In</th>
        <th style="min-width: 30px">Out</th>
        <th style="min-width: 30px">In</th>
        <th style="min-width: 30px">Out</th>
        <th style="min-width: 30px">In</th>
        <th style="min-width: 30px">Out</th>

    </tr>
    </thead>
    <tbody>
    @for($i = 1; $i<$days_in_this_month; $i++)
        @php
            $day = Str::of($i)->padLeft(2,'0');
            $carbonDate = Carbon::parse($month.'-'.$day);
        @endphp
        <tr class="text-center">
            <td style="color: {{$carbonDate->dayOfWeek == 6 || $carbonDate->dayOfWeek == 0 ? 'red' : 'black'}}">
                {{$day}}
            </td>
            <td>
                @php
                    $time = $dtrs->where(function ($dtr) use($carbonDate){
                            return $dtr->type == 10 && Str::of($dtr->timestamp)->contains($carbonDate->format('Y-m-d'));
                        })?->last()?->timestamp
                @endphp
                {{Helper::dateFormat($time,'H:i')}}
            </td>
            <td>
                @php
                    $time = $dtrs->where(function ($dtr) use($carbonDate){
                            return $dtr->type == 20 && Str::of($dtr->timestamp)->contains($carbonDate->format('Y-m-d'));
                        })?->last()?->timestamp
                @endphp
                {{Helper::dateFormat($time,'H:i')}}
            </td>
            <td>
                @php
                    $time = $dtrs->where(function ($dtr) use($carbonDate){
                            return $dtr->type == 30 && Str::of($dtr->timestamp)->contains($carbonDate->format('Y-m-d'));
                        })?->last()?->timestamp
                @endphp
                {{Helper::dateFormat($time,'H:i')}}
            </td>
            <td>
                @php
                    $time = $dtrs->where(function ($dtr) use($carbonDate){
                            return $dtr->type == 40 && Str::of($dtr->timestamp)->contains($carbonDate->format('Y-m-d'));
                        })?->last()?->timestamp
                @endphp
                {{Helper::dateFormat($time,'H:i')}}
            </td>

            <td>
                @php
                    $time = $dtrs->where(function ($dtr) use($carbonDate){
                            return $dtr->type == 50 && Str::of($dtr->timestamp)->contains($carbonDate->format('Y-m-d'));
                        })?->last()?->timestamp
                @endphp
                {{Helper::dateFormat($time,'H:i')}}
            </td>
            <td>
                @php
                    $time = $dtrs->where(function ($dtr) use($carbonDate){
                            return $dtr->type == 60 && Str::of($dtr->timestamp)->contains($carbonDate->format('Y-m-d'));
                        })?->last()?->timestamp
                @endphp
                {{Helper::dateFormat($time,'H:i')}}
            </td>
            <td>
            </td>
            <td>
            </td>
            <td class="text-left">
                @isset($holidays[Helper::dateFormat($carbonDate,'Y-m-d')])
                    HOL
                @endisset
            </td>
        </tr>

    @endfor


    </tbody>
</table>
<table style="font-family: 'Helvetica'; font-size: 14px; margin-top: 5px;margin-bottom: 0px;border: 0px; width: 100%">
    <tr>
        <td style="font-family: 'OS-Condenesed-Bold';">Total Late : <span style="font-family: 'HunDin'"></span></td>
        <td style="font-family: 'OS-Condenesed-Bold';">Total Saturday: <span style="font-family: 'HunDin'"></span></td>
    </tr>
    <tr>
        <td style="font-family: 'OS-Condenesed-Bold';">Total Undertime : <span style="font-family: 'HunDin'"></span></td>
        <td style="font-family: 'OS-Condenesed-Bold';">Total Sunday: <span style="font-family: 'HunDin'"></span></td>
    </tr>
</table>

<div>
    <p style="font-size: 14px; font-family: 'OS-Condenesed-Bold'; margin-top: 35px">I hereby certify that the above records are true and correct</p>

    <div style="float: right; padding-right: 10px; margin-top: 15px">
        ___________________________
        <p class="text-center" style="margin-top: 0">Signature of Employee</p>
    </div>
    <br><br><br>
    <table style="width: 100%;  border-collapse: collapse; border-spacing: 0; margin-bottom: 14px ">
        <tr>
            <td class="text-center" style=" font-size: 14px;font-family: Arial !important;padding: 0px;">{{request()->get('official_name')}}</td>
            <td style="width: 40%;padding: 0px;"></td>
        </tr>
        <tr>
            <td class="text-center" style="font-family: Arial !important;padding: 0px; font-weight: normal; font-style: italic; font-size: 8px">{{request()->get('official_position')}}</td>
            <td style="width: 40%;padding: 0px;"></td>
        </tr>
        <tr>
            <td class="text-center" style="border-top: 1px solid black;padding: 0px;font-family: Arial; font-weight: normal; font-size: 14px">Authorized Official</td>
            <td style="padding: 0px;"></td>
        </tr>
    </table>
</div>
<div>
    <p style="font-size: 10px;float: left; display: none">2022/PPSPD/MIS | {{Auth::user()->username}} | {{request()->ip()}}</p>
</div>