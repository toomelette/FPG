@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">

        @include('printables.print_layouts.header-hrrs')
        <h4 class="text-strong">Permission Slips for the Month of {{Carbon::parse(\Illuminate\Support\Facades\Request::get('month'))->format('F Y')}}</h4>
        @forelse($grouped as $LFEMi => $permissionSlips)
            <p class="text-strong no-margin">{{$LFEMi ?? $permissionSlips->first()->employee_name}}</p>
            <table style="width: 100%; margin-bottom: 15px" class="tbl-padded tbl-bordered">
                <thead>
                <tr>
                    <th style="width: 80px" class="text-center">Date</th>
                    <th style="width: 80px" class="text-center">PS No</th>
                    <th class="text-center">Purpose</th>
                    <th style="width: 60px" class="text-center">Type</th>
                    <th style="width: 40px" class="text-center">Direct</th>
                    <th style="width: 85px" class="text-center">Time out</th>
                    <th style="width: 85px" class="text-center">Time in</th>
                    <th style="width: 100px" class="text-center">Time spent (m)</th>
                </tr>
                </thead>
                <tbody>

                @forelse($permissionSlips as $permissionSlip)
                    <tr>
                        <td>{{Helper::dateFormat($permissionSlip->date,'M d, Y')}}</td>
                        <td class="text-center">{{$permissionSlip->ps_no}}</td>
                        <td>{{Str::of($permissionSlip->purpose)->lower()->ucfirst()}}</td>
                        <td class="text-center">{{$permissionSlip->personal_official}}</td>
                        <td class="text-center">{{$permissionSlip->direct_nondirect == 'DIRECT' ? '✓' : ''}}</td>
                        <td class="text-center">{{Helper::dateFormat($permissionSlip->departure,'h:i A')}}</td>
                        <td class="text-center">{{Helper::dateFormat($permissionSlip->return,'h:i A')}}</td>
                        <td class="text-center">
                            {{$permissionSlip->time_spent}}
                        </td>
                    </tr>
                @empty
                @endforelse
                    <tr class="text-strong">
                        <td colspan="7">
                            Total
                        </td>
                        <td class="text-center">
                            {{$permissionSlips->sum('time_spent')}}
                        </td>
                    </tr>
                </tbody>
            </table>
        @empty
        @endforelse
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        // print();

    </script>
@endsection