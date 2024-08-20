<div class="row">
    <div class="col-md-2 col-lg-3 col-xl-2 col-xxl-1 pe-0">
        @if(!empty($data->employee) && $data->employee->photo != null )
            @if(\File::exists(public_path('symlink/employee_pics/uploaded_50/'.$data->employee->photo)))
                <img src="{{asset('symlink/employee_pics/uploaded_50/'.$data->employee->photo)}}" class="avatar img-fluid rounded me-1" alt="User Image">
            @else
                <img src="{{asset('images/avatar.jpeg')}}" class="avatar img-fluid rounded me-1" alt="User Image">
            @endif
        @else
            <img src="{{asset('images/avatar.jpeg')}}" class="avatar img-fluid rounded me-1" alt="User Image">
        @endif
    </div>
    <div class="col-md-10 col-lg-9 col-xl-10 col-xxl-11 ps-0">
        <p class="text-strong mb-0">
            <a href="{{route('dashboard.employee.index')}}?find={{$data?->employee?->employee_no}}" target="_blank">{{$data->employee->full['LFEMi'] ?? ''}}
            </a>
            @if(!empty($data->employee))
                @php
                    $default_pword = Carbon::parse($data->employee->date_of_birth)->format('mdy');
                    $add = '';
                @endphp
                @if(!Hash::check($default_pword,$data->password))
                    <span class="float-end" title="User already changed default password"><i class="fa fa-lock"></i> </span>
                @endif
            @endif
        </p>
        <span class="small">
            {{$data?->employee?->plantill?->position ?? $data?->employee?->position}}
        </span>

    </div>
</div>