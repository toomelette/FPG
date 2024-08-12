@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Leave Cards</x-slot:title>
        <x-slot:float-end>{{$employee->full['LFEMi']}}</x-slot:float-end>
    </x-adminkit.html.page-title>

    <div class="row row-cols-4">
        @foreach(\App\Swep\Helpers\Arrays::leaveTypeCodes() as $code => $descriptiveName)
            <div class="col">
                <a href="{{route('dashboard.leave_card.view_per_leave_type',[$employee->slug,$code])}}">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">{{Str::limit($descriptiveName,25)}}</h5>
                                </div>
                                <div class="col-auto text-strong">
                                    {{$code}}
                                </div>
                            </div>
                            <h4 class="text-strong">
{{--                                {{Helper::toNumber(($leaveCredits->where('leave_card',$code)->first()->credits ?? 0) - ($leaveApplications->where('charge_to',$code)->first()->deduct ?? 0),3,'-')}}--}}
                                {{Helper::toNumber($leaveBalances[$code]['balance'],3,'-')}}
                            </h4>
                            <div class="mb-0 visually-hidden">
                                <span class="badge badge-success-light">+6.15%</span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">


    </script>
@endsection