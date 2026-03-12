@php
    $rand = Str::random();
@endphp
<form id="edit-template-form-{{$rand}}">

    <h3 class="box-title">
        <a href="{{route('dashboard.employee.index')}}?find={{$employee->employee_no}}" target="_blank"><span class="text-strong">{{$employee->full['LFEMi']}}</span></a>
        <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
    </h3>

    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-9">
                    <p class="no-margin">{{$employee->employee_no}}</p>
                    <p class="no-margin">{{$employee->plantilla->position ?? $employee->position}}</p>

                </div>
                <div class="col-md-3">
                    <table>
                        <tr>
                            <td style="padding-right: 10px"><small>Monthly Basic:</small></td>
                            <td><h4 class="no-margin">{{number_format($employee->jg_monthly_basic,2)}}</h4></td>
                        </tr>
                    </table>
                </div>
                <hr class="no-margin">
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" class="thumbnail">
                @if($employee->photo != null && file_exists(public_path($employee->photo_path['300'])))
                    <img src="{{asset($employee->photo_path['300'])}}" alt="..." class="img-thumbnail rounded me-2 mb-2">
                @else
                    <img src="{{asset('images/avatar.jpeg')}}" class="img-thumbnail rounded me-2 mb-2">
                @endif

            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-striped table-sm" >
                <thead>
                <tr>
                    <th>Salaries/Incentives/Bonuses</th>
                    <th>Code</th>
                    <th>Amount/Factor</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payrollAdjustments->where('type','INCENTIVE') as $adjustment)
                    <tr>
                        <td>{{$adjustment->description}}</td>
                        <td>{{$adjustment->code}}</td>
                        <td>
                            <x-forms.input :input-only="true"
                                           label=""
                                           name="adjustments[{{$adjustment->code}}]"
                                           cols="12"
                                           class="text-end autonum-{{$rand}}"
                                           autocomplete="off"
                                           :value="$employee?->payrollTemplates?->firstWhere('code',$adjustment->code)?->amount"
                            />
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-bordered table-striped table-sm" >
                <thead>
                <tr>
                    <th>Deductions</th>
                    <th>Code</th>
                    <th>Amount/Factor</th>
                </tr>
                </thead>
                <tbody>

                @forelse($payrollAdjustments->where('type','DEDUCTION') as $adjustment)
                    <tr>
                        <td>{{$adjustment->description}}</td>
                        <td>{{$adjustment->code}}</td>
                        <td>
                            <x-forms.input :input-only="true"
                                           label=""
                                           name="adjustments[{{$adjustment->code}}]"
                                           cols="12"
                                           class="text-end autonum-{{$rand}}"
                                           autocomplete="off"
                                           :value="$employee?->payrollTemplates?->firstWhere('code',$adjustment->code)?->amount"
                            />
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
    initializeAutonumByClass('.autonum-{{$rand}}');
    $("#edit-template-form-{{$rand}}").submit(function (e){
        e.preventDefault();
        let form = $(this);
        loading_btn(form);
        var url = '{{route("payroll-template.update", $employee->slug)}}';
        $.ajax({
            url : url,
            data : $(this).serialize(),
            type: 'PATCH',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,false,false);
                toast('info','Template successfully updated.','Success!');
            },
            error: function (res) {
                unwait_this_button(form.find('button[type="submit"]'))
            }
        })
    })
</script>