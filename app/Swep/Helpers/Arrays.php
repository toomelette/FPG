<?php


namespace App\Swep\Helpers;


use App\Models\Accounting\SubsidiaryAccounts;
use App\Models\Applicant;
use App\Models\ApplicantPositionApplied;
use App\Models\Budget\ChartOfAccounts;
use App\Models\DocumentFolder;
use App\Models\Employee;
use App\Models\HRPayPlanitilla;
use App\Models\HRU\Deductions;
use App\Models\HRU\Incentives;
use App\Models\MDDC;
use App\Models\PPU\Pap;
use App\Models\PPU\PPURespCodes;
use App\Models\PPU\RCDesc;
use App\Models\SSL;
use App\Models\SuOptions;
use Auth;
use Illuminate\Support\Carbon;
use Spatie\Html\Elements\P;

class Arrays
{
    public static function accessToDocuments(){
        return [
            'VIS' => 'VIS',
            'QC' => 'QC',
        ];
    }

    public static function imageSizes(){
        return [
            50 => 50,
            100 => 100,
            300 => 300,
            500 => 500,
            1000 => 1000,
        ];
    }

    public static function sex(){
        return [
            'MALE' => 'MALE',
            'FEMALE' => 'FEMALE',
        ];
    }

    public static function civil_status(){
        return [
            'SINGLE' => 'SINGLE',
            'MARRIED' => 'MARRIED',
            'WIDOWED' => 'WIDOWED',
            'DIVORCED' => 'DIVORCED',
            'SEPARATED' => 'SEPARATED',
        ];
    }

    public static function accessToEmployees(){
        return [
            'VIS' => 'VIS',
            'LM' => 'LM',
            'QC' => 'QC',
            'LGAREC' => 'LGAREC',
        ];
    }

    public static function payPlantillas(){
        $array = ['1'=>2];
        $pps = HRPayPlanitilla::query()->select('item_no','position')->get();
        if(!empty($pps)){
            foreach ($pps as $pp){
                $array[$pp->item_no] = $pp->position;
            }
        }
        return $array;
    }

    public static function payPlantillasWithItemNumber(){

        $pps = HRPayPlanitilla::query()->select('item_no','position')->get();
        return $pps->pluck('position','item_no')->map(function ($value,$key){
            return $key.' - '.$value;
        })->toArray();
    }

    public static function payPlantillasWithItemNumberAndDetails(){

        $pps = HRPayPlanitilla::query()->select('item_no','position','original_job_grade','original_job_grade_si')->get();
        return $pps->map(function ($data){
            return [
                'id' =>$data->item_no,
                'text' => $data->item_no.' - '.$data->position,
                'position' => $data->position,
                'salary_grade' => $data->original_job_grade,
                'step_inc' => $data->original_job_grade_si,
            ];
        });
    }

    public static function portals(){
        return [
            'ACCOUNTING' => 'ACCOUNTING',
            'DIGIFILE' => 'DIGIFILE',
            'PPU' => 'PPU',
            'MIS' => 'MIS',
        ];
    }
    public static function countries(){
        return [
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BQ" => "Bonaire, Sint Eustatius and Saba",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, Democratic Republic of the Congo",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CW" => "Curacao",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "XK" => "Kosovo",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "BL" => "Saint Barthelemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SX" => "Sint Maarten",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "SS" => "South Sudan",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.s.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ];
    }

    public static function fonts(){
        $a = [
            'Arial' => 'Arial',
            'Cambria'=> 'Cambria',
            'Calibri' => 'Calibri (default)',
            'Verdana' => 'Verdana',
            'Futura' => 'Futura',
            'Times New Roman' => 'Times New Roman',
            'Garamond' => 'Garamond',
            'Rockwell' => 'Rockwell',
            'Franklin Gothic'=> 'Franklin Gothic',

        ];
        ksort($a);
        return $a;
    }
    public static function fontSizes(){
        return [
            '8px' => '8px',
            '9px' => '9px',
            '10px' => '10px',
            '11px' => '11px',
            '12px' => '12px',
            '13px' => '13px',
            '14px' => '14px',
            '15px' => '15px',
            '16px' => '16px',
            '17px' => '17px',
        ];
    }

    public static function positionsAppliedFor(){
        $arr = [];
        $positions = ApplicantPositionApplied::query()->groupBy('position_applied')->orderBy('position_applied','asc')->get();
        foreach ($positions as $position){
            $arr[$position->position_applied] = $position->position_applied;
        }

        return $arr;
    }

    public static function orsFunds(){
        return [
            '01' => '01 - Personnel Services',
            '02' => '02 - MOOE',
            '04' => '04',
            '06' => '06 - Special Projects',
            '12' => '12',
            '20' => '20',
            '69' => '69',
        ];
    }

    public static function orsBooks(){
        return [
            'TEV' => 'TEV',
            'PAY' => 'PAY',
            'DV' => 'DV',
            'PO' => 'PO',
            'JO' => 'JO',
        ];
    }

    public static function oldOrsBooks(){
        $arr =[
            3 => 'TEV',
            0 => 'DV',
            1 => 'PO',
            2 => 'JO',
            'PAY' => 'PAY',
        ];
        ksort($arr);

        return $arr;
    }


    public static function groupedRespCodes($all = false){

        $rcs = PPURespCodes::query()->with(['description']);
        $userProjectId = Auth::user()->project_id ?? null;
        if($userProjectId != null){
            if($all == false){
                if($userProjectId == 1){
                    $rcs->where('vis','=',1);
                }
                if($userProjectId == 2){
                    $rcs->where('lm','=',1);
                }
            }
        }

        $rcs =  $rcs->get();
        $arr = [];

        if(!empty($rcs)){
            foreach ($rcs as $rc){
                $arr[$rc->description->name][$rc->rc_code] = $rc->desc;
            }
        }
        return $arr;
    }

    public static function years($past = 8, $future = 10){
        $years = [];
        $now_year = Carbon::now()->format('Y');
        for ( $x = $now_year - $past ; $x <= $now_year + $future; $x++){
            $years[$x] = $x;
        }
        return $years;
    }

    public static function respCodeList(){
        $rcs = PPURespCodes::query()->get();
        $arr = [];
        foreach ($rcs as $rc){
            $arr[$rc->rc_code] = [
                'dept_alias' => $rc->description->name,
                'dept' => $rc->department,
                'div' => $rc->division,
                'sec' => $rc->section,
            ];
        }
        return $arr;
    }

    public static function departmentList(){
        $depts = RCDesc::query()->get();
        $arr = [];
        if(count($depts) > 0){
            foreach ($depts as $dept) {
                $arr[$dept->rc] = $dept->name.' | '.$dept->descriptive_name ;
            }
        }
        return $arr;
    }

    public static function departmentListAbbv(){
        $depts = RCDesc::query()->get();
        $arr = [];
        if(count($depts) > 0){
            foreach ($depts as $dept) {
                $arr[$dept->rc] = $dept->name;
            }
        }
        return $arr;
    }

    public static function quartersArray(){
        $arr = [
            1 => 'FIRST',
            2 => 'SECOND',
            3 => 'THIRD',
            4 => 'FOURTH',
        ];
        return $arr;
    }

    public static function fundSources(){
        return [
            'COB' => 'COB',
            'SIDA' => 'SIDA',
        ];
    }

    public static function papTypes(){
        $arr = [];
        $ops = SuOptions::query()->where('for','=','papTypes')->get();
        if(!empty($ops)){
            foreach ($ops as $op){
                $arr[$op->option] = $op->value;
            }
        }
        ksort($arr);
        return $arr;
    }
    public static function activeInactive(){
        return[
            'active' => 'Active',
            'inactive' => 'Inactive',
        ];
    }

    public static function deptsAssoc(){
        $depts = RCDesc::query()->get();
        $arr = [];
        foreach ($depts as $dept){
            $arr[$dept->name] = null;
        }
        return $arr;
    }

    public static function chartOfAccounts(){
        $arr = [];
        $coas = ChartOfAccounts::query()->select('account_code','account_title')->get();
        if(!$coas->isEmpty()){
            return $coas
                ->pluck('account_title','account_code')
                ->map(function ($value,$key){
                    return $key.' | '.$value;
                })
                ->sort()
                ->toArray();
        }
        return null;
    }

    public static function employeeAssignments(){
        $mddc = MDDC::query()
            ->get();
        return [
            'OFFICE-BASED' => [
                'BACOLOD OFFICE' => 'BACOLOD OFFICE',
                'QUEZON CITY OFFICE' => 'QUEZON CITY OFFICE',
                'LGAREC OFFICE' => 'LGAREC  OFFICE',
                'LAREC OFFICE' => 'LAREC OFFICE',
            ],
            'FIELD' => $mddc->pluck('slug','slug')->sort()->toArray(),
        ];
    }

    public static function name_extensions(){
        return [
            'SR' => 'SR',
            'JR' => 'JR',
            'I' => 'I',
            'II' => 'II',
            'III' => 'III',
            'IV' => 'IV',
            'V' => 'V',
        ];
    }

    public static function educationalLevelsLimited(){
        return [
            'VOCATIONAL/TRADE COURSE' => 'VOCATIONAL/TRADE COURSE',
            'COLLEGE' => 'COLLEGE',
            'GRADUATE STUDIES' => 'GRADUATE STUDIES',
        ];
    }

    public static function acctgFundSources(){
        return [
            'LBP - ACEF, Current' => 'LBP - ACEF, Current',
            'LBP Bacolod (0422-1248-70)' => 'LBP Bacolod (0422-1248-70)',
            'LBP Bacolod (ACEF)' => 'LBP Bacolod (ACEF)',
            'LBP Bacolod (Block Farming)' => 'LBP Bacolod (Block Farming)',
            'LBP Bacolod (CA# 0422-1234-66) Other Projects' => 'LBP Bacolod (CA# 0422-1234-66) Other Projects',
            'LBP Bacolod (SIDA)' => 'LBP Bacolod (SIDA)',
            'LBP-Bacolod (Corporate)' => 'LBP-Bacolod (Corporate)',
        ];
    }

    public static function collectingOfficers(){
        $coa = ChartOfAccounts::query()
            ->select('name_of_collecting_officer')
            ->where('name_of_collecting_officer','!=',null)
            ->where('name_of_collecting_officer','!=','')
            ->orderBy('name_of_collecting_officer','asc')
            ->get();
        return $coa->mapWithKeys(function ($data){
            return [
                $data->name_of_collecting_officer => $data->name_of_collecting_officer,
            ];
        })->toArray();
    }

    public static function groupedSubsidiaryAccounts(){
        $sa = SubsidiaryAccounts::query()->select('sa_account_code_header','sa_account_code','sa_name')->get();
        $arr = [];
        foreach ($sa as $s){
            $arr[$s->sa_account_code_header][$s->sa_account_code] = $s->sa_account_code.' - '. $s->sa_name;
        }
        return $arr;
    }

    public static function budgetMovements(){
        return [
            'REALIGNMENT',
            'SUPPLEMENTAL',
        ];
    }

    public static function budgetTypes(){
        return [
            'PS' => 'PS',
            'MOOE' => 'MOOE',
            'CO' => 'CO',
        ];
    }

    public static function papCodes(){
        $paps = Pap::query()->get();
        return $paps->mapWithKeys(function ($data){
            return [
                $data->slug => $data->pap_code.' - '.$data->pap_title,
            ];
        })->toArray();
    }

    public static function plantillaColumnsForReport(){
        return [
            'item_no' => [
                'name' => 'Item No.',
                'checked' => 1,
            ],
            'position' => [
                'name' => 'Position',
                'checked' => 1,
            ],
            'employee_name' => [
                'name' => 'Name of Employee',
                'checked' => 1,
            ],
            'employee_no' => [
                'name' => 'Employee No.',
                'checked' => 0,
            ],
            'job_grade' => [
                'name' => 'Job Grade',
                'checked' => 1,
            ],
            'step_inc' => [
                'name' => 'Step Inc.',
                'checked' => 1,
            ],
            'actual_salary' => [
                'name' => 'Actual Salary',
                'checked' => 1,
            ],
            'actual_salary_gcg' => [
                'name' => 'Actual Salary (GCG)',
                'checked' => 1,
            ],
            'eligibility' => [
                'name' => 'Eligibility',
                'checked' => 1,
            ],
            'educ_att' => [
                'name' => 'Highest Educ Att',
                'checked' => 1,
            ],
            'appointment_status' => [
                'name' => 'Appt. Status',
                'checked' => 1,
            ],
            'appointment_date' => [
                'name' => 'Appt. Date',
                'checked' => 1,
            ],
            'adjustment_date' => [
                'name' => 'Date of Last Promotion',
                'checked' => 1,
            ],
        ];
    }

    public static function leaveTypesForView(){
        return [
            'Vacation Leave' => ' (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Mandatory/Forced Leave' => '(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Sick Leave' => '(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Maternity Leave' => ' (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)',
            'Paternity Leave' => ' (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)',
            'Special Privilege Leave' => ' (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Solo Parent Leave' => '(RA No. 8972 / CSC MC No. 8, s. 2004)',
            'Study Leave' => ' (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292) ',
            '10-Day VAWC Leave' => ' (RA No. 9262 / CSC MC No. 15, s. 2005) ',
            'Rehabilitation Privilege' => ' (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)',
            'Special Leave Benefits for Women' => '(RA No. 9710 / CSC MC No. 25, s. 2010)',
            'Special Emergency (Calamity) Leave' => ' (CSC MC No. 2, s. 2012, as amended)',
            'Adoption Leave' => '(R.A. No. 8552) ',
            'Others' => '',
        ];
    }

    public static function leaveTypes(){
        return [
            'Vacation Leave' => 'Vacation Leave',
            'Mandatory/Forced Leave' => 'Mandatory/Forced Leave',
            'Sick Leave' => 'Sick Leave',
            'Maternity Leave' => 'Maternity Leave',
            'Paternity Leave' => 'Paternity Leave',
            'Special Privilege Leave' => 'Special Privilege Leave',
            'Solo Parent Leave' => 'Solo Parent Leave',
            'Study Leave' => 'Study Leave',
            '10-Day VAWC Leave' => '10-Day VAWC Leave',
            'Rehabilitation Privilege' => 'Rehabilitation Privilege',
            'Special Leave Benefits for Women' => 'Special Leave Benefits for Women',
            'Special Emergency (Calamity) Leave' => 'Special Emergency (Calamity) Leave',
            'Adoption Leave' => 'Adoption Leave',
            'Others' => 'Others',
        ];
    }

    public static function leaveTypesJson(){
        return [
            'Vacation Leave' => [
                'Within the Philippines' => null,
                'Abroad' => 1,
            ],
            'Mandatory/Forced Leave' => null,
            'Sick Leave' => [
                'In Hospital' => 1,
                'Out Patient' => 1,
            ],
            'Maternity Leave' => null,
            'Paternity Leave' => null,
            'Special Privilege Leave' => [
                'Within the Philippines' => null,
                'Abroad' => 1,
            ],
            'Solo Parent Leave' => null,
            'Study Leave' => [
                "Completion of Master's Degree" => null,
                'BAR/Board Exam Review' => null,
            ],
            '10-Day VAWC Leave' => null,
            'Rehabilitation Privilege' => null,
            'Special Leave Benefits for Women' => 1,
            'Special Emergency (Calamity) Leave' => null,
            'Adoption Leave' => null,
            'Others' => [
                'Monetization of Leave Credits' => null,
                'Terminal Leave' => null,
            ],
        ];
    }

    public static function leaveTypesTree(){
        return [
            'Vacation Leave' => [
                'Within the Philippines' => 'Abroad',
                'Abroad' => 'Abroad',
            ],
            'Mandatory/Forced Leave' => "Mandatory/Forced Leave",
            'Sick Leave' => [
                'In Hospital' => 'In Hospital',
                'Out Patient' => 'Out Patient',
            ],
            'Maternity Leave' => "Maternity Leave",
            'Paternity Leave' => "Paternity Leave",
            'Special Privilege Leave' => [
                'Within the Philippines' => "Within the Philippines",
                'Abroad' => 'Abroad',
            ],
            'Solo Parent Leave' => "Solo Parent Leave",
            'Study Leave' => [
                "Completion of Master's Degree" => "Completion of Master's Degree",
                'BAR/Board Exam Review' => "BAR/Board Exam Review",
            ],
            '10-Day VAWC Leave' => "10-Day VAWC Leave",
            'Rehabilitation Privilege' => "Rehabilitation Privilege",
            'Special Leave Benefits for Women' => 'Special Leave Benefits for Women',
            'Special Emergency (Calamity) Leave' => "Special Emergency (Calamity) Leave",
            'Adoption Leave' => "Adoption Leave",
            'Others' => [
                'Monetization of Leave Credits' => "Monetization of Leave Credits",
                'Terminal Leave' => "Terminal Leave",
            ],
        ];
    }

    public static function payrollTypes(){
        return [
            'MONTHLY' => 'MONTHLY',
            'RATA' => 'RATA',
        ];
    }

    public static function jobGrades(){
        $ssls = SSL::query()->where('date_implemented','=','2022')
            ->orderBy('salary_grade','asc')
            ->get();
        return $ssls->mapWithKeys(function ($data){
            return [
                $data->salary_grade => [
                    1 => $data->step1,
                    2 => $data->step2,
                    3 => $data->step3,
                    4 => $data->step4,
                    5 => $data->step5,
                    6 => $data->step6,
                    7 => $data->step7,
                    8 => $data->step8,
                ]
            ];
        });
    }

    public static function incentives(){
        $incs = Incentives::query()->get();
        return $incs->mapWithKeys(function ($data){
            return [
                $data->incentive_code => $data,
            ];
        })->toArray();
    }

    public static function deductionsExcelHeader($groupings = null){
        $deds = Deductions::query()
            ->where('excel_header','!=',null);
        if($groupings != null){
            $deds->where('groupings','=',$groupings);
        }
        $deds = $deds->get();
        return $deds->mapWithKeys(function ($data){
            return [
                $data->excel_header => $data,
            ];
        });
    }

    public static function employeesGsisToSlug(){
        $emps = Employee::query()->active()->permanent()->get();
        return $emps->mapWithKeys(function ($data){
            return [
                $data->gsis => $data->slug,
            ];
        });
    }
    public static function employeeNoToSlug(){
        $emps = Employee::query()->active()->permanent()->applyProjectId()->get();
        return $emps->mapWithKeys(function ($data){
            return [
                $data->employee_no => $data->slug,
            ];
        });
    }

    public static function employeesKeyedBySlug(){
        $emps = Employee::query()->active()->permanent()->get();
        return $emps->mapWithKeys(function ($data){
            return [
                $data->slug => $data,
            ];
        });
    }

    public static function appointmentStatus(){
        $oraohra = [
            'PERMANENT' => 'PERMANENT',
            'CONTRACTUAL' => 'CONTRACTUAL',
            'TEMPORARY' => 'TEMPORARY',
            'COTERMINOUS' => 'COTERMINOUS',
            'FIXED TERM' => 'FIXED TERM',
            'SUBSTITUTE' => 'SUBSTITUTE',
            'PROVISIONAL' => 'PROVISIONAL',
            'REAPPOINTMENT' => 'REAPPOINTMENT'
        ];
        $others = [
            'PROBATIONARY' => 'PROBATIONARY',
            'PART-TIME' => 'PART-TIME',
            'PACKIAO' => 'PACKIAO',
            'JOB ORDER' => 'JOB ORDER',
            'COS' => 'COS',
            'PROJECT-BASED' => 'PROJECT-BASED',
            'CASUAL' => 'CASUAL',
        ];
        ksort($oraohra);
        ksort($others);
        return [
            'ORAOHRA' => $oraohra,
            'OTHERS' => $others,
        ];
    }

    public static function jobGradeLevels(){
        $levels = [];
        for ($i = 1;$i <= 33; $i ++){
            $levels[$i] = $i;
        }
        return $levels;
    }

    public static function stepIncements(){
        $levels = [];
        for ($i = 1;$i <= 8; $i ++){
            $levels[$i] = $i;
        }
        return $levels;
    }

    public static function folderCodes()
    {
       $folders = DocumentFolder::query()
           ->select('folder_code','description')
           ->orderBy('folder_code','asc')
           ->get();
       return $folders->mapWithKeys(function ($data){
           return [
               $data->folder_code => $data->folder_code .' - '.$data->description,
           ];
       });
    }

    public static function retentionPeriods()
    {
        return [
            '12' => '1 Year',
            '24' => '2 Years',
            '36' => '3 Years',
            '48' => '4 Years',
            '60' => '5 Years',
        ];
    }
    public static function filterEmployees()
    {
        return [
            '' => 'ALL',
            'paidInCheck' => 'Paid in check',
        ];
    }
}