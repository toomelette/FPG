<div class="card">
    <div class="card-body">
        <h5 class="card-title">Payslips</h5>
        <div class="accordion" id="accordionExample">
            @forelse($payrollMonths as $year => $months)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button {{$year != Carbon::now()->format('Y') ? "collapsed" : ""}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$year}}" aria-expanded="true" aria-controls="collapse{{$year}}">
                            {{$year}}
                        </button>
                    </h2>
                    <div id="collapse{{$year}}" class="accordion-collapse collapse {{$year == Carbon::now()->format('Y') ? "show" : ""}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                @foreach($months as $month)
                                    <div class="col-md-2 col-sm-4 col-lg-2 col-xl-2 col-xxl-1">
                                        <button style="width: 100%;" class="btn {{Carbon::now()->format('Y-m-01') == $month ? 'btn-success': 'btn-outline-primary'}}  payslip-btn mb-2"  data="{{$month}}" {{$payrollsOfThisEmployee->where('date','=',$month)->count() == 0 ? 'disabled' : '' }} payroll="{{$payrollsOfThisEmployee->where('date','=',$month)?->first()?->slug}}">
                                            {{strtoupper(Carbon::parse($month)->format('M'))}}
                                        </button>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>