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
    <p class="text-center" style="font-size: 16px">
        <b>NOTICE OF SALARY ADJUSTMENT</b>
    </p>

    <p class="text-right">
        {{\Illuminate\Support\Carbon::now()->format('F d, Y')}}
    </p>

    <p>
        <span style="font-size: 18px ">
            <b>{{($employee->sex == 'FEMALE') ? 'Ms.' : 'Mr.'}} {{$employee->firstname}} {{\Illuminate\Support\Str::limit($employee->middlename,1,'.')}} {{$employee->lastname}}</b>
        </span>
        <br>
        Sugar Regulatory Administration
    </p>

    <p>
        {{($employee->sex == 'FEMALE') ? "Madam" : 'Sir'}},
    </p>

    <p style="text-align: justify">
        Pursuant to CPCS Implementing Guidelines No. 2021-1 dated January 12, 2022, implementing Executive Order No. 150 s 2021, your salary is hereby adjusted effective
        {{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('effectivity'))->format('F d, Y')}}
        as follows:
    </p>

    <table style="width: 100%">
        <tr>
            <td style="width: 15px; vertical-align: top">1.</td>
            <td style="width: 80%">
                Adjusted monthly basic salary effective
                {{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('effectivity'))->format('F d, Y')}}
                under the new salary schedule
                JG <b>{{\Illuminate\Support\Facades\Request::get('new_salary_grade')}}</b>
                Step <b>{{\Illuminate\Support\Facades\Request::get('new_step_inc')}}</b>
            </td>
            <td class="text-right" style="vertical-align: top">
                <u>
                    <p class="editable">
                        {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('new_monthly_salary')),2)}}
                    </p>
                </u>
            </td>
        </tr>

        <tr>
            <td style="width: 15px; vertical-align: top">2.</td>
            <td>
                Actual monthly salary as of
                {{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('as_of'))->format('F d, Y')}}
                SG <b>{{\Illuminate\Support\Facades\Request::get('salary_grade')}}</b>
                Step <b>{{\Illuminate\Support\Facades\Request::get('step_inc')}}</b>
            </td>
            <td class="text-right" style="vertical-align: top">
                <u>
                    <p class="editable">
                        {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('monthly_basic')),2)}}

                    </p>
                </u>
            </td>
        </tr>

        <tr>
            <td style="width: 15px; vertical-align: top">3.</td>
            <td>
                Monthly Salary Adjustment effective
                {{\Carbon\Carbon::parse(\Illuminate\Support\Facades\Request::get('effectivity'))->format('F d, Y')}}
            </td>
            <td class="text-right" style="vertical-align: top">
                <u>
                    <p class="editable">
                        {{number_format(\App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('new_monthly_salary')) - \App\Swep\Helpers\Helper::sanitizeNumFormat(\Illuminate\Support\Facades\Request::get('monthly_basic')),2)}}
                    </p>
                </u>
            </td>
        </tr>

    </table>

<p style="text-align: justify">This salary adjustment is subject to review and post-audit, and to appropriate re-adjustment and refund if found not in order.</p>

<div style="overflow: auto">
    <div style="width: 40%; float: right">
        <p class="text-center">
            Very truly yours,<br><br><br>
        </p>

        <p class="text-center">
            <b>{{\Illuminate\Support\Facades\Request::get('signatory_name')}}</b>
            <br>
            {{\Illuminate\Support\Facades\Request::get('signatory_position')}}
        </p>
    </div>
</div>

<p>
    Position Title:<b> {{strtoupper(\Illuminate\Support\Facades\Request::get('new_position'))}}</b>
    <br>
    Job Grade:  <b>{{\Illuminate\Support\Facades\Request::get('new_salary_grade')}}</b> Step:  <b>{{\Illuminate\Support\Facades\Request::get('new_step_inc')}}</b>
</p>
<p>
    Item No./ Unique Item No., FY 2021 Personal Services Itemization <br> and/or Plantilla of Personnel:  <b>{{\Illuminate\Support\Facades\Request::get('new_item_no')}}</b>
</p>

<table>
    <tr>
        <td>Copy Furnished:</td>
        <td>GSIS</td>
    </tr>
    <tr>
        <td></td>
        <td>Accounting</td>
    </tr>
</table>


    <div style="overflow: auto">
        <div style="width: 30%; float: right;">
        <p>
            FM-AFD-HRS-034, Rev. 001<br>Effectivity Date: March 8, 2022
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