@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Reports</x-slot:title>
        <x-slot:subtitle> Payroll</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <div class="tab tab-vertical">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="#vertical-icon-tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">
                    Consolidate Differential
                </a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active show" id="vertical-icon-tab-1" role="tabpanel">
                <h4 class="tab-title">Consolidate Differential</h4>
                <div class="row">
                    <div class="col-md-4">
                        <form method="GET" target="_blank" >
                            @php
                                $diffs = \App\Models\HRU\PayrollMaster::query()
                                    ->where('type','like','DIFF%')
                                    ->orderBy('date')
                                    ->orderBy('type')
                                    ->get();
                            @endphp
                            <label>
                                <input name="generate" style="display: none">
                            </label>
                            <label>
                                <input name="type" style="display: none" value="per_month">
                            </label>
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 50px;"></th>
                                    <th>Month</th>
                                    <th>Type</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($diffs as $diff)
                                    <tr>
                                        <td>
                                            <label>
                                                <input class="payroll-selector" type="checkbox" checked name="payrolls[]" value="{{$diff->slug}}">
                                            </label>
                                        </td>
                                        <td>
                                            {{Helper::dateFormat($diff->date,'Y F')}}
                                        </td>
                                        <td>
                                            {{$diff->type}}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>

                            <div class="row">
                                <x-forms.checkbox type="checkbox" label="Payroll Group" name="payrollGroupsSelected" cols="12" :options="\App\Swep\Helpers\Arrays::payrollGroups()" required="required"/>
                            </div>

                            <div class="row">
                                <x-forms.select label="Report Type" name="type" cols="12" :options="['per_month' => 'CONSOLIDATED', 'main' => 'MAIN PAYROLL','gsis' => 'GSIS Contribution']" required="required"/>
                            </div>


                            <button type="submit" class="btn btn-sm btn-primary mt-2"><i class="fa fa-print"></i> Generate</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="vertical-icon-tab-2" role="tabpanel">
                <h4 class="tab-title">Another one</h4>

            </div>
            <div class="tab-pane" id="vertical-icon-tab-3" role="tabpanel">
                <h4 class="tab-title">One more</h4>

            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $('.payroll-selector').iCheck({
            checkboxClass: 'icheckbox_flat-blue checkbox-counter',
            radioClass   : 'iradio_flat-green'
        })

    </script>
@endsection