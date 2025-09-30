@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; padding-top: 180px">
        <p class="text-center text-strong" style="font-size: 18px">NOTICE OF STEP INCREMENT DUE TO LENGTH OF SERVICE</p>
        <br> <br>
        <p>
            <b>{{($employee->sex == 'FEMALE') ? 'Ms.' : 'Mr.'}} {{$employee->firstname}} {{\Illuminate\Support\Str::limit($employee->middlename,1,'.')}} {{$employee->lastname}}</b>
            <br>
            Sugar Regulatory Administration
            <br>
            {{Auth::user()->project_id == 1 ? 'Bacolod City': 'Quezon City'}}
            <br><br>
        </p>

        {{($employee->sex == 'FEMALE') ? 'Ms.' : 'Mr.'}} {{Str::of($employee->lastname)->lower()->ucfirst()}},

        <p style="text-indent: 20px; text-align: justify">
            {!! Str::of(request('body'))
                    ->replace('$position$','<b>'.request('new_position').'</b>')
                    ->replace('$effectivity$','<b>'.Carbon::parse(request('effectivity'))->format('F d, Y').'</b>')
             !!}
        </p>

        <table style="width: 93%;font-size: 14px; margin-left: 25px">
            <tr>
                <td style="width: 15px;">1.</td>
                <td style="width: 75%">
                    Adjusted monthly basic as of
                    <b><u>{{Carbon::parse(request('effectivity'))->subDays(1)->format('F d, Y')}}</u></b>

                </td>
                <td class="text-right">
                    <u>
                        <p class="editable text-strong">
                            {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(request('monthly_basic')),2)}}
                        </p>
                    </u>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 40px">
                    {{request('new_salary_type')}} <b><u>{{request('new_salary_grade')}}</u></b>
                    Step <b><u>{{request('step_inc')}}</u></b>
                </td>
                <td></td>
            </tr>

            <tr>
                <td style="width: 15px; ">2.</td>
                <td>
                    Add: one (1) Step Increment
                </td>
                <td class="text-right" style="">
                    <u>
                        <p class="editable text-strong">
                            {{number_format(Helper::sanitizeNumFormat(request('new_monthly_salary')) - Helper::sanitizeNumFormat(request('monthly_basic')),2)}}
                        </p>
                    </u>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 40px">
                    Due to Length of Service
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 15px; ">3.</td>
                <td>
                    Adjusted monthly Basic Salary
                </td>
                <td class="text-right" style="">
                    <u>
                        <p class="editable text-strong">
                            {{number_format(Helper::sanitizeNumFormat(request('new_monthly_salary') ?? 0),2)}}

                        </p>
                    </u>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-left: 40px">
                    effective <b><u>{{Carbon::parse(request('effectivity'))->format('F d, Y')}}</u></b> : {{request('new_salary_type')}} <b><u>{{request('new_salary_grade')}}</u></b> Step <b><u>{{request('new_step_inc')}}</u></b>
                </td>
                <td></td>
            </tr>

        </table>

        <p style="text-align: justify; margin-top: 20px">This salary adjustment is subject to review and post-audit, and to appropriate re-adjustment and refund if found not in order.</p>

        <div style="overflow: auto">
            <div style="width: 40%; float: right">
                <p class="">
                    Very truly yours,<br><br><br>
                </p>

                <p class="">
                    <b>{{request('signatory_name')}}</b>
                    <span style="white-space: pre-line">
                {{request('signatory_position')}}
            </span>
                </p>
            </div>
        </div>

        <p style="font-size: 12px">
            Item No:  <b><u>{{request('new_item_no')}}</u></b><br>
            Personal Services Itemization and/or Plantilla of Personnel
        </p>

        <table style="font-size: 12px; border-collapse: collapse">
            <tr>
                <td style="vertical-align: top">Copy Furnished:</td>
                <td>Accounting</td>
            </tr>

        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection