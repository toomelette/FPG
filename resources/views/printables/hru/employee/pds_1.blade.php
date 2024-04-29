@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
<div style="font-family: Arial">
    <table class="tbl b-side b-tb">
        <tr>
            <td colspan="3">
                CS Form No. 212 <br>
                Revised 2017
                <p class="text-center" style="font-size: 22px; font-family: 'Arial Black'">
                    PERSONAL DATA SHEET
                </p>
                <p class="text-strong f-10 no-margin text-italic">
                    WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.
                </p>
                <p class="text-strong f-10 no-margin text-italic">
                    READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.
                </p>
            </td>
        </tr>
        <tr style="font-family: 'Arial Narrow'">
            <td style="width: 70%">
                <p class="f-10 no-margin">
                    Print legibly. Tick appropriate boxes (□) and use separate sheet if necessary. Indicate N/A if not applicable.  <b>DO NOT ABBREVIATE.</b>
                </p>
            </td>
            <td class="f-10 b-side b-tb pds-light-fill">
                1. CS ID No.
            </td>
            <td class="f-10 b-side b-tb text-right">
                (Do not fill up. For CSC use only)
            </td>
        </tr>
    </table>
    <table class="tbl f-13 b-side b-bottom" style="font-family: 'Arial Narrow'">
        <tr>
            <td class="text-strong pds-dark-fill">I. PERSONAL INFORMATION</td>
        </tr>
    </table>
    <table class="tbl f-10 b-side b-bottom tbl-pds-25 tbl-padded" style="font-family: 'Arial Narrow'">
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill">2.</td>
            <td style="width: 130px" class="b-right pds-light-fill">SURNAME</td>
            <td colspan="3" class="text-strong b-bottom">{{strtoupper($employee->lastname)}}</td>
        </tr>
        <tr>
            <td class="pds-light-fill"></td>
            <td class="b-right pds-light-fill">FIRST NAME</td>
            <td style="width: 50%" class="text-strong b-tb">{{strtoupper($employee->firstname)}}</td>
            <td class="b-left pds-light-fill text-top">NAME EXTENSION (JR., SR) </td>
            <td class="b-right pds-light-fill">{{$employee->name_ext ?? 'N/A'}}</td>
        </tr>
        <tr>
            <td class="pds-light-fill"></td>
            <td class="b-right pds-light-fill">MIDDLE NAME</td>
            <td colspan="3" class="text-strong b-tb">{{strtoupper($employee->middlename ?? 'N/A')}}</td>
        </tr>
    </table>

    <table class="tbl f-10 b-side b-bottom tbl-pds-25 tbl-padded" style="font-family: 'Arial Narrow'">
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill text-top">3.</td>
            <td style="width: 130px" class="b-right pds-light-fill">DATE OF BIRTH <br> (mm/dd/yyy)</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{Carbon::parse($employee->date_of_birth)->format('m/d/Y')}}</td>
            <td class="pds-light-fill" style="width: 15px">16.</td>
            <td class="pds-light-fill">CITIZENSHIP</td>
            <td>

            </td>
        </tr>
        <tr>
            <td class="text-right pds-light-fill">4.</td>
            <td  class="b-right pds-light-fill">PLACE OF BIRTH</td>
            <td class="b-right b-bottom text-center">{{$employee->place_of_birth}}</td>
        </tr>
        <tr>
            <td class="text-right pds-light-fill">5.</td>
            <td class="b-right pds-light-fill">SEX</td>
            <td class="b-right b-bottom">
                <table class="tbl f-10">
                    @if($employee->sex == 'MALE')
                        <tr>
                            <td style="width: 50%"> ☑ MALE</td>
                            <td>◻ FEMALE</td>
                        </tr>
                    @else
                        <tr>
                            <td style="width: 50%"> ◻ MALE</td>
                            <td>☑ FEMALE</td>
                        </tr>
                    @endif
                </table>

            </td>
        </tr>
    </table>
    <table class="tbl f-10 b-side b-bottom tbl-pds-25 tbl-padded" style="font-family: 'Arial Narrow'">
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill">6.</td>
            <td style="width: 130px" class="b-right pds-light-fill">CIVIL STATUS</td>
            <td class="b-right b-bottom" style="width: 120px">
                <table class="tbl tbl-pds-5 f-10">
                        <tr>
                            <td style="width: 50%"> {{ $employee->civil_status == 'SINGLE' ? '☑' : '◻' }} Single</td>
                            <td>{{ $employee->civil_status == 'MARRIED' ? '☑' : '◻' }} Married</td>
                        </tr>
                        <tr>
                            <td style="width: 50%"> {{ $employee->civil_status == 'WIDOWED' ? '☑' : '◻' }} Widowed</td>
                            <td>{{ $employee->civil_status == 'SEPARATED' ? '☑' : '◻' }} Separated</td>
                        </tr>
                        <tr>
                            <td style="width: 50%"> ◻ Other/s:</td>
                            <td></td>
                        </tr>
                </table>
            </td>
            <td class="pds-light-fill text-top b-right b-bottom" rowspan="2" style="width: 135px">17. RESIDENTIAL ADDRESS</td>
            <td rowspan="2" class="b-bottom" style="padding: 0">
                <table class="tbl tbl-pds-5">
                    <tr>
                        <td style="width: 50%" class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->res_address_block}}
                        </td>
                        <td class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->res_address_street}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-italic f-10 b-bottom">House/Block/Lot No.</td>
                        <td class="text-center text-italic f-10 b-bottom">Street</td>
                    </tr>
                    <tr>
                        <td style="width: 50%" class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->res_address_village}}
                        </td>
                        <td class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->res_address_barangay}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-italic f-10 b-bottom">Subdivision/Village</td>
                        <td class="text-center text-italic f-10 b-bottom">Barangay</td>
                    </tr>
                    <tr>
                        <td style="width: 50%" class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->res_address_city}}
                        </td>
                        <td class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->res_address_province}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-italic f-10">City/Municipality</td>
                        <td class="text-center text-italic f-10">Province</td>
                    </tr>
                </table>
            </td>

        </tr>

        <tr>
            <td class="text-right pds-light-fill b-top">7.</td>
            <td class="b-right pds-light-fill b-top">HEIGHT (m)</td>
            <td class="b-right b-bottom text-center" style="width: 120px">
                {{$employee->height}}
            </td>
        </tr>
        <tr>
            <td class="text-right pds-light-fill b-top">8.</td>
            <td class="b-right pds-light-fill b-top">Weight (kg)</td>
            <td class="b-right b-bottom text-center" style="width: 120px">
                {{$employee->weight}}
            </td>
            <td class="text-center pds-light-fill  b-right b-bottom">
                ZIP CODE
            </td>
            <td class="text-center">
                {{$employee->employeeAddress->res_address_zipcode}}
            </td>
        </tr>
    </table>
    <table class="tbl f-10 b-side b-bottom tbl-pds-25 tbl-padded" style="font-family: 'Arial Narrow'">
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">9.</td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">BLOOD TYPE</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->blood_type}}</td>
            <td class="pds-light-fill text-top b-right b-bottom" rowspan="3" style="width: 135px">18. PERMANENT ADDRESS</td>
            <td rowspan="3" style="padding: 0" class="b-bottom">
                <table class="tbl tbl-pds-5">
                    <tr>
                        <td style="width: 50%" class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->perm_address_block}}
                        </td>
                        <td class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->perm_address_street}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-italic f-10 b-bottom">House/Block/Lot No.</td>
                        <td class="text-center text-italic f-10 b-bottom">Street</td>
                    </tr>
                    <tr>
                        <td style="width: 50%" class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->perm_address_village}}
                        </td>
                        <td class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->perm_address_barangay}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-italic f-10 b-bottom">Subdivision/Village</td>
                        <td class="text-center text-italic f-10 b-bottom">Barangay</td>
                    </tr>
                    <tr>
                        <td style="width: 50%" class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->perm_address_city}}
                        </td>
                        <td class="text-strong text-center b-bottom f-10">
                            {{$employee->employeeAddress->perm_address_province}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center text-italic f-10 ">City/Municipality</td>
                        <td class="text-center text-italic f-10 ">Province</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="text-right pds-light-fill b-bottom">10.</td>
            <td class="b-right pds-light-fill b-bottom">GSIS ID NO.</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->gsis ?? 'N/A'}}</td>
        </tr>
        <tr>
            <td class="text-right pds-light-fill b-bottom">11.</td>
            <td class="b-right pds-light-fill b-bottom">PAG-IBIG ID NO.</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->hdmf ?? 'N/A'}}</td>
        </tr>
        <tr>
            <td class="text-right pds-light-fill b-bottom">12.</td>
            <td class="b-right pds-light-fill b-bottom">PHILHEALTH NO.</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->philhealth ?? 'N/A'}}</td>
            <td class="text-center pds-light-fill  b-right">
                ZIP CODE
            </td>
            <td class="text-center">
                {{$employee->employeeAddress->perm_address_zipcode}}
            </td>
        </tr>
    </table>
    <table class="tbl f-10 b-side b-bottom tbl-pds-25 tbl-padded" style="font-family: 'Arial Narrow'">
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">13.</td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">SSS NO.</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->sss ?? 'N/A'}}</td>
            <td class="pds-light-fill b-right b-bottom" style="width: 135px">19. TELEPHONE NO.</td>
            <td  class="b-bottom text-center">{{$employee->tel_no ?? 'N/A'}}</td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">14.</td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">TIN NO.</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->tin ?? 'N/A'}}</td>
            <td class="pds-light-fill b-right b-bottom" style="width: 135px">20. MOBILE NO.</td>
            <td  class="b-bottom text-center">{{$employee->cell_no ?? 'N/A'}}</td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">15.</td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">AGENCY EMPLOYEE NO.</td>
            <td class="b-right b-bottom text-center" style="width: 120px">{{$employee->employee_no ?? 'N/A'}}</td>
            <td class="pds-light-fill b-right b-bottom" style="width: 135px">21. E-MAIL ADDRESS (if any)</td>
            <td  class="b-bottom text-center">{{$employee->email ?? 'N/A'}}</td>
        </tr>
    </table>
    <table class="tbl f-13 b-side b-bottom" style="font-family: 'Arial Narrow'">
        <tr>
            <td class="text-strong pds-dark-fill">II. FAMILY BACKGROUND</td>
        </tr>
    </table>
    <table class="tbl f-10 b-side b-bottom tbl-pds-25 tbl-padded" style="font-family: 'Arial Narrow'">
        @php
            $children = $employee->employeeChildren->toArray();
        @endphp
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">22.</td>
            <td class="b-right pds-light-fill b-bottom">SPOUSE'S SURNAME</td>
            <td class="b-right b-bottom text-center" colspan="2">{{$employee->employeeFamilyDetail->spouse_lastname ?? 'N/A'}}</td>
            <td class="b-bottom pds-light-fill b-right" style="width: 30%">23. NAME of CHILDREN  (Write full name and list all)</td>
            <td class="b-bottom pds-light-fill text-center">DATE OF BIRTH (mm/dd/yyyy) </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">FIRST NAME</td>
            <td class="b-right b-bottom text-center" style="width: 120px"> {{$employee->employeeFamilyDetail->spouse_firstname ?? 'N/A'}}</td>
            <td class="pds-light-fill b-right b-bottom text-top" style="width: 135px"><span style="font-size: 8px">NAME EXTENSION (JR., SR)</span></td>
            <td class="text-center b-bottom b-right">
                @if($employee->employeeChildren->count() > 0)
                    {{$children[0]['fullname'] ?? ''}}
                @else
                    N/A
                @endif
            </td>
            <td class="text-center b-bottom">
                @if($employee->employeeChildren->count() > 0)
                    {{Helper::dateFormat($children[0]['date_of_birth'] ?? null,'m/d/Y')}}
                @else
                    N/A
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">MIDDLE NAME</td>
            <td class="b-right b-bottom text-center" colspan="2" style="width: 120px"> {{$employee->employeeFamilyDetail->spouse_middlename ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[1]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[1]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">OCCUPATION</td>
            <td class="b-right b-bottom text-center" colspan="2" style="width: 120px"> {{$employee->employeeFamilyDetail->spouse_occupation ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[2]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[2]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">EMPLOYER/BUSINESS NAME</td>
            <td class="b-right b-bottom text-center" colspan="2" style="width: 120px"> {{$employee->employeeFamilyDetail->spouse_employer ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[3]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[3]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">BUSINESS ADDRESS</td>
            <td class="b-right b-bottom text-center" colspan="2" style="width: 120px"> {{$employee->employeeFamilyDetail->spouse_business_address ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[4]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[4]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">TELEPHONE NO.</td>
            <td class="b-right b-bottom text-center" colspan="2" style="width: 120px"> {{$employee->employeeFamilyDetail->spouse_tel_no ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[5]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[5]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>

        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">23.</td>
            <td class="b-right pds-light-fill b-bottom">FATHER'S SURNAME</td>
            <td class="b-right b-bottom text-center" colspan="2">{{$employee->employeeFamilyDetail->father_lastname ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[6]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[6]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">FIRST NAME</td>
            <td class="b-right b-bottom text-center"> {{$employee->employeeFamilyDetail->father_firstname ?? 'N/A'}}</td>
            <td class="pds-light-fill b-right b-bottom text-top"><span style="font-size: 8px">NAME EXTENSION (JR., SR)</span> {{$employee->employeeFamilyDetail->father_name_ext}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[7]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[7]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">FIRST NAME</td>
            <td class="b-right b-bottom text-center" colspan="2">{{$employee->employeeFamilyDetail->father_middlename ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[8]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[8]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>

        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom">24.</td>
            <td class="b-right pds-light-fill b-bottom">MOTHER'S MAIDEN NAME</td>
            <td class="b-right b-bottom text-center" colspan="2">
                {{$employee->employeeFamilyDetail->mother_firstname}}
                {{$employee->employeeFamilyDetail->mother_middlename}}
                {{$employee->employeeFamilyDetail->mother_lastname}}
            </td>
            <td class="text-center b-bottom b-right">
                {{$children[9]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[9]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">SURNAME</td>
            <td class="b-right b-bottom text-center" colspan="2">{{$employee->employeeFamilyDetail->mother_lastname ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[10]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[10]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">FIRST NAME</td>
            <td class="b-right b-bottom text-center" colspan="2">{{$employee->employeeFamilyDetail->mother_firstname ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[11]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[11]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
        <tr>
            <td style="width: 16px" class="text-right pds-light-fill b-bottom"></td>
            <td style="width: 130px" class="b-right pds-light-fill b-bottom">MIDDLE NAME</td>
            <td class="b-right b-bottom text-center" colspan="2">{{$employee->employeeFamilyDetail->mother_middlename ?? 'N/A'}}</td>
            <td class="text-center b-bottom b-right">
                {{$children[12]['fullname'] ?? ''}}
            </td>
            <td class="text-center b-bottom">
                {{Helper::dateFormat($children[12]['date_of_birth'] ?? null,'m/d/Y')}}
            </td>
        </tr>
    </table>
    <table class="tbl f-10 b-side b-bottom tbl-bordered" style="font-family: 'Arial Narrow'">
        <tr>
            <td class="text-strong pds-dark-fill f-13" colspan="8">III.  EDUCATIONAL BACKGROUND</td>
        </tr>
        <tr>
            <td class="text-center pds-light-fill" rowspan="2">LEVEL</td>
            <td class="text-center pds-light-fill" rowspan="2">NAME OF SCHOOL (Write in full)</td>
            <td class="text-center pds-light-fill" rowspan="2">BASIC EDUCATION/DEGREE/ (Write in full)</td>
            <td class="text-center pds-light-fill" colspan="2">PERIOD OF ATTENDANCE</td>
            <td class="text-center pds-light-fill" rowspan="2">HIGHEST LEVEL/UNITS EARNED (if not graduated)</td>
            <td class="text-center pds-light-fill" rowspan="2">YEAR GRADUATED</td>
            <td class="text-center pds-light-fill" rowspan="2">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</td>
        </tr>
        <tr>
            <td class="text-center pds-light-fill">FROM</td>
            <td class="text-center pds-light-fill">TO</td>
        </tr>
        <tr>
            <td class="pds-light-fill">ELEMENTARY</td>
            @php
                $elementary = $employee->employeeEducationalBackground->where('level','ELEMENTARY')->sortByDesc('graduate_year')->first();
            @endphp
            @if(!empty($elementary))
                <td class="text-center">{{$elementary->school_name ?? 'N/A'}}</td>
                <td class="text-center">{{$elementary->course ?? 'N/A'}}</td>
                <td class="text-center">{{$elementary->date_from ?? 'N/A'}}</td>
                <td class="text-center">{{$elementary->date_to ?? 'N/A'}}</td>
                <td class="text-center">{{$elementary->units ?? 'N/A'}}</td>
                <td class="text-center">{{$elementary->graduate_year ?? 'N/A'}}</td>
                <td class="text-center">{{$elementary->honor ?? 'N/A'}}</td>
            @else
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            @endif
        </tr>
        <tr>
            <td class="pds-light-fill">SECONDARY</td>
            @php
                $secondary = $employee->employeeEducationalBackground->where('level','SECONDARY')->sortByDesc('graduate_year')->first();
            @endphp
            @if(!empty($secondary))
                <td class="text-center">{{$secondary->school_name ?? 'N/A'}}</td>
                <td class="text-center">{{$secondary->course ?? 'N/A'}}</td>
                <td class="text-center">{{$secondary->date_from ?? 'N/A'}}</td>
                <td class="text-center">{{$secondary->date_to ?? 'N/A'}}</td>
                <td class="text-center">{{$secondary->units ?? 'N/A'}}</td>
                <td class="text-center">{{$secondary->graduate_year ?? 'N/A'}}</td>
                <td class="text-center">{{$secondary->honor ?? 'N/A'}}</td>
            @else
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            @endif
        </tr>
        <tr>
            <td class="pds-light-fill">VOCATIONAL/TRADE COURSE</td>
            @php
                $vocational = $employee->employeeEducationalBackground->where('level','VOCATIONAL/TRADE COURSE')->sortByDesc('graduate_year')->first();
            @endphp
            @if(!empty($vocational))
                <td class="text-center">{{$vocational->school_name ?? 'N/A'}}</td>
                <td class="text-center">{{$vocational->course ?? 'N/A'}}</td>
                <td class="text-center">{{$vocational->date_from ?? 'N/A'}}</td>
                <td class="text-center">{{$vocational->date_to ?? 'N/A'}}</td>
                <td class="text-center">{{$vocational->units ?? 'N/A'}}</td>
                <td class="text-center">{{$vocational->graduate_year ?? 'N/A'}}</td>
                <td class="text-center">{{$vocational->honor ?? 'N/A'}}</td>
            @else
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            @endif
        </tr>
        <tr>
            <td class="pds-light-fill">COLLEGE</td>
            @php
                $college = $employee->employeeEducationalBackground->where('level','COLLEGE')->sortByDesc('graduate_year')->first();
            @endphp
            @if(!empty($college))
                <td class="text-center">{{$college->school_name ?? 'N/A'}}</td>
                <td class="text-center">{{$college->course ?? 'N/A'}}</td>
                <td class="text-center">{{$college->date_from ?? 'N/A'}}</td>
                <td class="text-center">{{$college->date_to ?? 'N/A'}}</td>
                <td class="text-center">{{$college->units ?? 'N/A'}}</td>
                <td class="text-center">{{$college->graduate_year ?? 'N/A'}}</td>
                <td class="text-center">{{$college->honor ?? 'N/A'}}</td>
            @else
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            @endif
        </tr>
        <tr>
            <td class="pds-light-fill">GRADUATE STUDIES</td>
            @php
                $grad = $employee->employeeEducationalBackground->where('level','GRADUATE STUDIES')->sortByDesc('graduate_year')->first();
            @endphp
            @if(!empty($grad))
                <td class="text-center">{{$grad->school_name ?? 'N/A'}}</td>
                <td class="text-center">{{$grad->course ?? 'N/A'}}</td>
                <td class="text-center">{{$grad->date_from ?? 'N/A'}}</td>
                <td class="text-center">{{$grad->date_to ?? 'N/A'}}</td>
                <td class="text-center">{{$grad->units ?? 'N/A'}}</td>
                <td class="text-center">{{$grad->graduate_year ?? 'N/A'}}</td>
                <td class="text-center">{{$grad->honor ?? 'N/A'}}</td>
            @else
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            @endif
        </tr>
    </table>

</div>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            let set = 625;
            if ($("#items_table_{{$rand}}").height() < set) {
                let rem = set - $("#items_table_{{$rand}}").height();
                $("#adjuster").css('height', rem)
                print();
            }
        })
        window.onafterprint = function () {
            window.close();
        }
    </script>
@endsection