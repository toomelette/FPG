<html>
<head>
    <style>
        body{
            font-family: Cambria !important;
        }

        .edit_form{
            margin-bottom: 0px;
        }

    </style>
    <link type="text/css" rel="stylesheet" href="{{asset('css/print.css')}}?rand={{\Illuminate\Support\Str::random()}}">
    <script type="text/javascript" src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <title>
        NOTICE OF SALARY ADJUSTMENT
    </title>
</head>
<body style="padding-top: 175px; font-size: 14px">
<p class="text-center" style="font-size: 18px">
    <b>NOTICE OF SALARY ADJUSTMENT</b>
    <br><br>
</p>

<p class="">
    {{\Illuminate\Support\Carbon::now()->format('F d, Y')}}
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
    Pursuant to CPCS Implementing Guidelines No. 2021-1 dated January 12, 2022, implementing Executive Order No. 150 s 2021,
    and Sugar Regulatory Administration Board Resolution No. 2023-157 dated September 26, 2023 duly approved by GCG on March 25, 2024,
    your salary is hereby adjusted effective
    <b><u>{{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('effectivity'))->format('F d, Y')}}</u></b>
    as follows:
</p>

<table style="width: 93%;font-size: 14px; margin-left: 25px">
    <tr>
        <td style="width: 15px; vertical-align: top">1.</td>
        <td style="width: 75%">
            Adjusted monthly basic salary effective
            <b><u>{{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('effectivity'))->format('F d, Y')}}</u></b>
            under the new salary schedule
            JG <b>{{\Illuminate\Support\Facades\Request::get('new_salary_grade')}}</b>
            Step <b>{{\Illuminate\Support\Facades\Request::get('new_step_inc')}}</b>
        </td>
        <td class="text-right" style="vertical-align: top">
            <u>
                <p class="editable text-strong">
                    {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('new_monthly_salary')),2)}}
                </p>
            </u>
        </td>
    </tr>

    <tr>
        <td style="width: 15px; vertical-align: top">2.</td>
        <td>
            Actual monthly salary as of
            <b><u>{{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('as_of'))->format('F d, Y')}}</u></b>
            JG <b>{{\Illuminate\Support\Facades\Request::get('salary_grade')}}</b>
            Step <b>{{\Illuminate\Support\Facades\Request::get('step_inc')}}</b>
        </td>
        <td class="text-right" style="vertical-align: top">
            <u>
                <p class="editable text-strong">
                    {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('monthly_basic')),2)}}
                </p>
            </u>
        </td>
    </tr>

    <tr>
        <td style="width: 15px; vertical-align: top">3.</td>
        <td>
            Monthly Salary Adjustment effective
            <b><u>{{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('effectivity'))->format('F d, Y')}}</u></b>
        </td>
        <td class="text-right" style="vertical-align: top">
            <u>
                <p class="editable text-strong">
                    {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('new_monthly_salary')) - \App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('monthly_basic')),2)}}
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
            <b>{{\Illuminate\Support\Facades\Request::get('signatory_name')}}</b>
            <span style="white-space: pre-line">
                {{\Illuminate\Support\Facades\Request::get('signatory_position')}}
            </span>
        </p>
    </div>
</div>

<p style="font-size: 12px">
    Position Title:<b> {{strtoupper(\Illuminate\Support\Facades\Request::get('new_position'))}}</b>
    <br>
    Job Grade:  <b>{{\Illuminate\Support\Facades\Request::get('new_salary_grade')}}</b> Step:  <b>{{\Illuminate\Support\Facades\Request::get('new_step_inc')}}</b>
</p>
<p style="font-size: 12px">
    Item No./ Unique Item No., FY 2021 Personal Services Itemization <br> and/or Plantilla of Personnel:  <b>{{\Illuminate\Support\Facades\Request::get('new_item_no')}}</b>
</p>

<table style="font-size: 12px; border-collapse: collapse">
    <tr>
        <td style="vertical-align: top">Copy Furnished:</td>
        <td>GSIS <br> Accounting</td>
    </tr>

</table>


<div style="overflow: auto">
    <div style="width: 20%; float: right; font-size: 10px">
        <p>
            FM-AFD-HRS-034, Rev. 002<br>Effectivity Date: April 4, 2024
        </p>
    </div>
</div>

<script>
    $("body").on('dblclick',".editable",function () {
        let p = $(this);
        p.removeClass('editable');
        p.addClass('non-editable');
        let old_value = $(this).html();
        $(this).html('<form class="edit_form"><input class="inpt" type="text" value="'+old_value+'"></form>')
    })

    $("body").on("submit",".edit_form",function (e) {
        e.preventDefault();
        let form = $(this);
        let p = form.parent('p');
        let input = p.find(".inpt");
        input.remove();
        p.html(input.val());
        p.addClass('editable');
        p.removeClass('non-editable');

    })
</script>
</body>
</html>