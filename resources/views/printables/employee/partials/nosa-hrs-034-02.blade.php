<div style="font-family: Cambria; padding-top: 180px">
    <p class="text-center" style="font-size: 18px">
        <b>NOTICE OF SALARY ADJUSTMENT</b>
        <br><br>
    </p>

    <p class="">
        {{Carbon::parse($request->header_date)->format('F d, Y')}}
        <br><br>
    </p>

    <p>
        <span>
            <b>{{($employee->sex == 'FEMALE') ? 'Ms.' : 'Mr.'}} {{$employee->firstname}} {{\Illuminate\Support\Str::limit($employee->middlename,1,'.')}} {{$employee->lastname}}</b>
        </span>
        <br>
        Sugar Regulatory Administration
        <br>
        {{Auth::user()->project_id == 1 ? 'Bacolod City': 'Quezon City'}}
        <br><br>
    </p>

    <p>
        {{($employee->sex == 'FEMALE') ? "Madam" : 'Sir'}},
    </p>

    <p style="text-align: justify">

        {!!
            Str::of($request->body)
                ->replace(Carbon::parse($request->effectivity)->format('F d, Y'),'<b>'.Carbon::parse($request->effectivity)->format('F d, Y').'</b>')
                ->replace('January 01, 2025','<b>January 01, 2025</b>')
                ->replace('October 22, 2025','<b>October 22, 2025</b>')
                ->replace('2025-01','<b>2025-01</b>')
        !!}
    </p>

    <table style="width: 93%;font-size: 14px; margin-left: 25px">
        <tr>
            <td style="width: 15px; vertical-align: top">1.</td>
            <td style="width: 75%" class="text-top">
                Adjusted monthly basic salary effective
                <b>{{Carbon::parse($request->effectivity)->format('F d, Y')}}</b>
                under the new salary schedule
                {{$request->new_salary_type}} <b><u>{{$request->new_salary_grade}}</u></b>
                Step <b><u>{{$request->new_step_inc}}</u></b>
            </td>
            <td class="text-right text-top" style="vertical-align: top">
                <u>
                    <p class="editable text-strong">
                        Php {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat($request->new_monthly_salary),2)}}
                    </p>
                </u>
            </td>
        </tr>

        <tr>
            <td style="width: 15px; vertical-align: top">2.</td>
            <td class="text-top">
                Actual monthly salary as of
                <b>
                    @php
                        if(isset($request->before_effectivity)){
                            $bf = $request->before_effectivity;
                        }else{
                            $bf = null;
                        }
                    @endphp
                    @if($bf == null)
                        {{Carbon::parse($request->effectivity)->subDays(1)->format('F d, Y')}}
                    @else
                        {{Carbon::parse($bf)->format('F d, Y')}}
                    @endif

                </b>
                {{$request->salary_type}} <b><u>{{$request->salary_grade}}</u></b>
                Step <b><u>{{$request->step_inc}}</u></b>
            </td>
            <td class="text-right text-top" style="vertical-align: top">
                <u>
                    <p class="editable text-strong">
                        Php {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat($request->monthly_basic ?? 0),2)}}
                    </p>
                </u>
            </td>
        </tr>

        <tr>
            <td style="width: 15px; vertical-align: top">3.</td>
            <td class="text-top">
                Monthly Salary Adjustment effective
                <b>{{Carbon::parse($request->effectivity)->format('F d, Y')}}</b>
            </td>
            <td class="text-right" style="vertical-align: top">
                <u>
                    <p class="editable text-strong">

                        Php {{number_format(Helper::sanitizeNumFormat($request->new_monthly_salary) - Helper::sanitizeNumFormat($request->monthly_basic),2)}}
                    </p>
                </u>
            </td>
        </tr>

    </table>

    <p style="text-align: justify">This salary adjustment is subject to review and post-audit, and to appropriate re-adjustment and refund if found not in order.</p>

    <div style="overflow: auto">
        <div style="width: 40%; float: right">
            <p class="">
                Very truly yours,<br><br><br>
            </p>

            <p class="">
                <b>{{$request->signatory_name}}</b>
                <span style="white-space: pre-line">
                {{$request->signatory_position}}
            </span>
            </p>
        </div>
    </div>

    <p style="font-size: 12px">
        Position Title:<b> {{strtoupper($request->new_position)}}</b>
        <br>
        {{\App\Swep\Helpers\Arrays::salaryTypes()[$request->new_salary_type] ?? '-'}}:  <b>{{$request->new_salary_grade}}</b> Step:  <b>{{$request->new_step_inc}}</b>
    </p>
    <p style="font-size: 12px">
        Item No./ Unique Item No., FY 2025 Personal Services Itemization <br> and/or Plantilla of Personnel:  <b>{{\Illuminate\Support\Facades\Request::get('new_item_no')}}</b>
    </p>

    <table style="font-size: 12px; border-collapse: collapse">
        <tr>
            <td style="vertical-align: top">Copy Furnished:</td>
            <td>GSIS <br> Accounting</td>
        </tr>

    </table>


    <div style="overflow: auto">
        <div style="width: 20%; float: right; font-size: 10px">
            <p style="display: none">
                FM-AFD-HRS-034, Rev. 002<br>Effectivity Date: April 4, 2024
            </p>
        </div>
    </div>
</div>
