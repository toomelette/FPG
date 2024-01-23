
<?php

  $f = __dataType::date_parse($leave_application->working_days_date_from, 'F d, Y');
  $mf = __dataType::date_parse($leave_application->working_days_date_from, 'F');
  $df = __dataType::date_parse($leave_application->working_days_date_from, 'd');
  $yf = __dataType::date_parse($leave_application->working_days_date_from, 'Y');
  $mdf = __dataType::date_parse($leave_application->working_days_date_from, 'F d');
  $t = __dataType::date_parse($leave_application->working_days_date_to, 'F d, Y');
  $mt = __dataType::date_parse($leave_application->working_days_date_to, 'F');
  $dt = __dataType::date_parse($leave_application->working_days_date_to, 'd');
  $mdt = __dataType::date_parse($leave_application->working_days_date_to, 'M d');

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Leave Application</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">

  <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/print.css') }}?s={{\Illuminate\Support\Str::random()}}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">

  <style type="text/css">
      
    .div-height{

      margin-bottom: -50px; 
      padding-bottom: 50px; 
      overflow: hidden;

    }

  </style>

</head>
<body onload="window.print();" onafterprint="window.close()">
{{-- <body onload="" onafterprint=""> --}}
<div>

  <div class="wrapper" style="">


      {{-- HEADER --}}
      <div class="row">
        
        <div class="col-md-1"></div>

        <div class="col-md-10" style="text-align: center;">

          <span style="font-weight:bold; font-size:18px; text-decoration: underline;">APPLICATION FOR LEAVE</span>

        </div>

        <div class="col-md-1"></div>

      </div>


      {{-- DOCUMENT Version --}}
      <div class="row" style="border-bottom:solid 1.4px;">

        <div class="col-sm-12 pull-left">
          <span style="font-size:14px;">CSC Form No. 6</span><br>
          <span style="font-size:14px;">Revised 2020 </span>
        </div>

      </div>


      {{-- Name --}}
      <div class="row" style="border-bottom:solid 1.4px;">

        <div class="col-sm-4">
          <span style="font-size:14px;">1.  OFFICE/AGENCY</span><br>
          <span style="font-weight: bold; font-size:13px;">{{ $leave_application->agency }}</span>
        </div>

        <div class="col-sm-3">
          <span style="font-size:14px;">2.  NAME(Last)</span><br>
          <span style="font-weight: bold; font-size:13px;">{{ $leave_application->lastname }}</span>
        </div>

        <div class="col-sm-3">
          <span style="font-size:14px;">(First)  </span><br>
          <span style="font-weight: bold; font-size:13px;">{{ $leave_application->firstname }}</span>
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px;">(Middle)</span><br>
          <span style="font-weight: bold; font-size:13px;">{{ $leave_application->middlename }}</span>
        </div>

      </div>



      {{-- Date of Filing --}}
      <div class="row" style="border-bottom:solid 1.4px;">

        <div class="col-sm-4">
          <span style="font-size:14px;">3.  DATE OF FILING</span><br>
          <span style="font-weight: bold; font-size:13px;">{{ __dataType::date_parse($leave_application->date_of_filing, 'F d,Y') }}</span>
        </div>

        <div class="col-sm-4">
          <span style="font-size:14px;">4.  POSITION</span><br>
          <span style="font-weight: bold; font-size:13px;">{{ $leave_application->position }}</span>
        </div>

        <div class="col-sm-4">
          <span style="font-size:14px;">5.   SALARY(Monthly)</span><br>
          <span style="font-weight: bold; font-size:13px;">{{ number_format($leave_application->salary, 2) }}</span>
        </div>

      </div>



      {{-- Details of Application --}}
      <div class="row" style="border-bottom:solid 1.4px;">

        <div class="col-sm-12" style="text-align:center;">
          <span style="font-weight:bold; font-size:15px; text-decoration: underline;">DETAILS OF APPLICATION</span>
        </div>

      </div>



      {{-- TYPE OF LEAVE --}}
      <div class="row" style="padding-bottom:10px;">

        <div class="col-sm-6"">
          <span style="font-size:14px;">6. a) TYPE OF LEAVE</span>
        </div>

        <div class="col-sm-6"">
          <span style="font-size:14px;">6. b) WHERE LEAVE WILL BE SPENT</span>
        </div>

      </div>



      {{-- VACATION --}}
      <div class="row">

        <div class="col-sm-1">
          @if($leave_application->type == 'VL')
            <div style="width: 20px; height: 20px; border: 10px solid;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px;">Vacation</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">(1) IN CASE OF VACATION LEAVE</span>
        </div>

      </div>




      {{-- To seek employment --}}
      <div class="row" style="padding-bottom:5px;">

        <div class="col-sm-1">
          @if($leave_application->type_vacation == 'TV1001')
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px; margin-left: 10px;">To seek employment</span>
        </div>

        <div class="col-sm-1">
          @if($leave_application->type == 'T1001' && $leave_application->spent_vacation == 'SV1001')
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px; margin-left: 10px;">Within the Philippines</span>
        </div>

      </div>




      {{-- Vacation (Others Specify) --}}
      <div class="row" style="padding-bottom:5px;">

        <div class="col-sm-1">
          @if($leave_application->type_vacation == 'TV1002')
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-5" style="word-wrap: break-word;">
          <span style="font-size:14px; margin-left:-30px; margin-left: 10px;">Others (Specify) &nbsp;&nbsp;</span>
          @if($leave_application->type_vacation == 'TV1002')
            <span style="text-decoration: underline; font-weight: bold;">{{ $leave_application->type_vacation_others_specific }}</span>
          @else
            ____________________ ____________________________________
          @endif
        </div>

        <div class="col-sm-1">
          @if($leave_application->type == 'T1001' && $leave_application->spent_vacation == 'SV1002')
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px; margin-left: 10px;">Abroad (Specify) &nbsp;&nbsp;</span>
          @if($leave_application->spent_vacation == 'SV1002')
            <span style="text-decoration: underline; font-weight: bold;">{{ $leave_application->spent_vacation_abroad_specific }}</span>
          @else
            ___________________ ____________________________________
          @endif
        </div>

      </div>




      {{-- SICK --}}
      <div class="row" style="padding-bottom:5px;">

        <div class="col-sm-1">
          @if($leave_application->type == 'SL')
            <div style="width: 20px; height: 20px; border: 10px solid;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px;">Sick</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">(2) IN CASE OF SICK LEAVE</span>
        </div>

      </div>




      {{-- MATERNITY --}}
      <div class="row" style="padding-bottom:5px;">

        <div class="col-sm-1">
          @if($leave_application->type == 'ML')
            <div style="width: 20px; height: 20px; border: 10px solid;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px;">Maternity</span>
        </div>

        <div class="col-sm-1">
          @if($leave_application->spent_sick == 'SS1001')
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px; margin-left: 10px;">In Hospital (Specify) &nbsp;&nbsp;</span>
          @if($leave_application->spent_sick == 'SS1001')
            <span style="text-decoration: underline; font-weight: bold;">{{ $leave_application->spent_sick_inhospital_specific }}</span>
          @else
            ________________ ____________________________________
          @endif
        </div>

      </div>




      {{-- OTHERS --}}
      <div class="row" style="padding-bottom:5px;">

        <div class="col-sm-1">
          @if($leave_application->type != 'SL' && $leave_application->type != 'ML' && $leave_application->type != 'VL')
            <div style="width: 20px; height: 20px; border: 10px solid;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px;">Others (Specify) &nbsp;&nbsp;</span>
          @if($leave_application->type == 'T1004')
            <span style="text-decoration: underline; font-weight: bold;"> {{ $leave_application->type_others_specific }}</span>
          @else
              @if($leave_application->type != 'SL' && $leave_application->type != 'ML' && $leave_application->type != 'VL')
            <u>{{array_search($leave_application->type ,__static::leave_types()) }}</u>
                ____________________________________
                @else
               _________________________
               ____________________________________
                @endif
          @endif
        </div>

        <div class="col-sm-1">
          @if($leave_application->spent_sick == 'SS1002')
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:-30px; margin-left: 10px;">Out Patient (Specify) &nbsp;&nbsp;</span>
          @if($leave_application->spent_sick == 'SS1002')
            <span style="text-decoration: underline; font-weight: bold;">{{ $leave_application->spent_sick_outpatient_specific }}</span>
          @else
            ________________ ____________________________________
          @endif
        </div>

      </div>



      {{-- WORKING DAYS --}}
      <div class="row">

        <div class="col-sm-6">
          <span style="font-size:14px;">6. (c) NUMBER OF WORKING DAYS APPLIED</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">6. (d) COMMUTATION</span>
        </div>

      </div>



      {{-- WORKING DAYS FOR --}}
      <div class="row">

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-2" style="padding:0;"">
              <span style="font-size:14px; margin-left: 20px;">FOR &nbsp;&nbsp;</span>
            </div>
            <div class="col-sm-10" style="border-bottom:solid 1.4px;">
              <span style="font-weight: bold;">{{ $leave_application->working_days }}</span>
            </div>
          </div>
        </div>

        <div class="col-sm-1">
           @if($leave_application->commutation == true)
            <div style="width: 20px; height: 20px; border: 10px solid; margin-left: 40px;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
          @endif
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px; margin-left: 10px;">Requested</span>
        </div>

        <div class="col-sm-1">
          @if($leave_application->commutation == false)
            <div style="width: 20px; height: 20px; border: 10px solid;"></div>
          @else
            <div style="width: 20px; height: 20px; border: 1.4px solid;"></div>
          @endif
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px; margin-left: -30px;">Not Requested</span>
        </div>

      </div>



      {{-- WORKING DAYS2 --}}
      <div class="row" style="padding-top: -80px;">

        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-5" style="padding:0;">
              <span style="font-size:14px; margin-left: 20px;">INCLUSIVE DATES</span>
            </div>
            <div class="col-sm-7" style="border-bottom: solid 1.4px;">
              @if($mf == $mt)
                @if($mdf == $mdt)
                  <span style="font-weight: bold;">{{ $mf .' '. $df .', '. $yf }}</span>
                @else 
                  <span style="font-weight: bold;">{{ $mf .' '. $df .' - '. $dt .', '. $yf }}</span>
                @endif
              @else
                <span style="font-weight: bold;">{{ $f .' - '. $t }}</span>
              @endif
            </div>
          </div>
        </div>

        <div class="col-sm-6"></div>

      </div>




      {{-- SIGNATURE --}}
      <div class="row">

        <div class="col-sm-6"></div>

        <div class="col-sm-6" style="text-align: center; padding-top: 20px;">
          <div class="col-sm-2"></div>
          <div class="col-sm-8" style="border-top:solid 1.4px; border-top-height: 20px; text-align: center;">
            <span style="font-size:14px;">(Signature of Applicant)</span>
          </div>
          <div class="col-sm-2"></div>
        </div>

      </div>




      {{-- Details of Action on Application --}}
      <div class="row" style="border-bottom:solid 1.4px; border-top:solid 1.4px;">

        <div class="col-sm-12" style="text-align:center;">
          <span style="font-weight:bold; font-size:15px;">DETAILS OF ACTION ON APPLICATION</span>
        </div>

      </div>




      {{-- CERTIFICATION --}}
      <div class="row">

        <div class="col-sm-6">
          <span style="font-size:14px;">7. (a) CERTIFICATION OF LEAVE CREDITS</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">7. (b) RECOMMENDATION</span>
        </div>

      </div>




      {{-- AS OF --}}
      <div class="row" style="padding-bottom:5px;">

        <div class="col-sm-6">
          <span style="font-size:14px; margin-left:20px;">as of ___________________________________</span>
        </div>

        <div class="col-sm-1">
          <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:10px;">Approval</span>
        </div>

      </div>




      {{-- Table1  --}}
      <div class="row" style="padding-bottom:15px;">

        <div class="col-sm-2">
          <span style="font-size:14px; text-decoration: underline;">Vacation</span>
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px; text-decoration: underline;">Sick</span>
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px; text-decoration: underline;">Total</span>
        </div>

        <div class="col-sm-1">
          <div style="width: 20px; height: 20px; border: 1.4px solid; margin-left: 40px;"></div>
        </div>

        <div class="col-sm-5">
          <span style="font-size:14px; margin-left:10px;">Disapproval due to _____________________________________</span>
        </div>

      </div>




      {{-- Table2  --}}
      <div class="row">

        <div class="col-sm-2">
          <span style="font-size:14px; border-top: solid 1.4px">Days</span>
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px; border-top: solid 1.4px">Days</span>
        </div>

        <div class="col-sm-2">
          <span style="font-size:14px; border-top: solid 1.4px">Days</span>
        </div>

        <div class="col-sm-6"></div>

      </div>



      {{-- Line  --}}
      <div class="row" style="padding-bottom:25px;">

        <div class="col-sm-6">_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ </div>

        <div class="col-sm-6"></div>

      </div>



      {{-- SIGNATORY --}}
      <div class="row">

        <div class="col-sm-6">
          <div class="col-sm-1"></div>
          <div class="col-sm-10" style="text-align: center; line-height: 12px;">
            <span style="font-size:14px; font-weight: bold;">{{ $leave_application->personnel_officer }}</span>
          </div>
          <div class="col-sm-1"></div>
        </div>

        <div class="col-sm-6" style="text-align: center; line-height: 12px;">
          <span style="font-size:14px; font-weight: bold;">{{ $leave_application->immediate_superior }}</span>
        </div>

      </div>




      {{-- SIGNATURE --}}
      <div class="row">

        <div class="col-sm-6">
          <div class="col-sm-1"></div>
          <div class="col-sm-10" style="border-top:solid 1.4px; text-align: center;">
            <span style="font-size:14px; font-weight: bold;">{{ $leave_application->personnel_officer_position }}</span>
          </div>
          <div class="col-sm-1"></div>
        </div>

        <div class="col-sm-6">
          <div class="col-sm-1"></div>
          <div class="col-sm-10" style="border-top:solid 1.4px; border-top-height: 20px; text-align: center;">
            <span style="font-size:14px; font-weight: bold;">{{ $leave_application->immediate_superior_position }}</span>
          </div>
          <div class="col-sm-1"></div>
        </div>

      </div>




      {{-- Just a Line --}}
      <div class="row" style="border-bottom:solid 1.4px;">
      </div>




      {{-- APPROVED FOR --}}
      <div class="row">

        <div class="col-sm-6">
          <span style="font-size:14px;">7. (c) APPROVED FOR:</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">7. (d) DISAPPROVED DUE TO:</span>
        </div>

      </div>




      {{-- APPROVED FOR cat's --}}
      <div class="row">

        <div class="col-sm-6">
          <span style="font-size:14px; margin-left: 20px;">_____ Days with pay</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">____________________________________________</span>
        </div>

      </div>




      {{-- APPROVED FOR cat's --}}
      <div class="row">

        <div class="col-sm-6">
          <span style="font-size:14px; margin-left: 20px;">_____ Days without pay</span>
        </div>

        <div class="col-sm-6">
          <span style="font-size:14px;">____________________________________________</span>
        </div>

      </div>




      {{-- APPROVED FOR cat's --}}
      <div class="row" style="padding-bottom:20px;">

        <div class="col-sm-6">
          <span style="font-size:14px; margin-left: 20px;">_____ Others (Specify)</span>
        </div>

        <div class="col-sm-6"></div>

      </div> 



      {{-- Signature --}}
      <div class="row" style="padding-bottom:15px;">

        <div class="col-sm-4"></div>

        <div class="col-sm-4" style="border-top:solid 1.4px; border-top-height: 20px; text-align: center;">
          <span style="font-size:14px; font-weight: bold;">(Signature)</span>
        </div>

        <div class="col-sm-4"></div>

      </div>




      {{-- SIGNATORY --}}
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10" style="text-align: center; line-height: 12px;">
          <span style="font-size:14px; font-weight: bold;"> ATTY. JOHANA S. JADOC </span>
        </div>
        <div class="col-sm-1"></div>
      </div>




      {{-- Signature --}}
      <div class="row">

        <div class="col-sm-4"></div>
        <div class="col-sm-4" style="border-top:solid 1.4px; border-top-height: 20px; text-align: center;">
          <span style="font-size:12px; font-weight: bold;">MANAGER III, AFD Visayas</span>
        </div>
        <div class="col-sm-4"></div>

      </div>



      {{-- Date --}}
      <div class="row">

        <div class="col-sm-6">
          <span style="font-size:14px;">DATE:________________________</span>
        </div>

      </div>



      {{-- Just a Line --}}
      <div class="row">
          <span>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
      </div>



      {{-- Date --}}
      <div class="row">
        <div class="col-sm-12" style="text-align: center;">
          <span style="font-size:14px; font-style:italic; ">(PLEASE SEE THE INSTRUCTION AT THE BACK)</span>
        </div>
      </div>



  </div>

</div>


{{-- SUFFIX --}}
<div class="row">
  
  <div class="col-sm-8 div-height" style="padding-bottom: 0px">
    <p style="font-size:10px;">Username: {!! Auth::user()->username !!} | Doc No: {{ $leave_application->doc_no }}</p>
  </div>

</div>


</body>
</html>

