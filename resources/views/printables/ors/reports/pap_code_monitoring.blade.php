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

    <div style="text-align:left">

        <h3 class="no-margin">PAP CODE MONITORING</h3>
        <p>
            @if(!empty($request->date_from) && !empty($request->date_to))
                For the period of {{\Illuminate\Support\Carbon::parse($request->date_from)->format('F d, Y')}} to  {{\Illuminate\Support\Carbon::parse($request->date_to)->format('F d, Y')}}
            @else
                All records
            @endif
        </p>
    </div>

    <table style="width: 100%;" class="tbl-padded tbl-bordered">
        <thead>
        <tr>
            <th>ORS No.</th>
            <th>Date</th>
            <th>Payee</th>
            <th>Particulars</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
        @endphp
        @forelse($ors as $or)

            <tr>
                <td>{{$or->ors_no}}</td>
                <td>{{Helper::dateFormat($or->ors_date,'m/d/Y')}}</td>
                <td>{{$or->payee}}</td>
                <td>{{$or->particulars}}</td>
                <td class="text-right">
                    @php
                        $orsEntries = $or->orsEntries->where('account_code',$account_code)
                    @endphp
                    @forelse($orsEntries as $orsEntry)
                        @php
                            $total = $total + $orsEntry->debit;
                        @endphp
                        {{Helper::toNumber($orsEntry->debit,2)}}
                    @empty
                    @endforelse
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" class="text-right">TOTAL</th>
            <th class="text-right">
                {{Helper::toNumber($total,2)}}
            </th>
        </tr>
        </tfoot>
    </table>
@endsection

@section('scripts')
    <script type="text/javascript">


    </script>
@endsection