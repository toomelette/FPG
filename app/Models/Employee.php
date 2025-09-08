<?php

namespace App\Models;

use App\Models\HRU\HrOtherActions;
use App\Models\HRU\LeaveApplicationDates;
use App\Models\HRU\LeaveBeginningBalance;
use App\Models\HRU\PayrollEmployeeSettings;
use App\Models\HRU\TemplateDeductions;
use App\Models\HRU\TemplateIncentives;
use App\Models\PPU\PPURespCodes;
use App\Models\SqlServer\EmpMaster;
use App\Models\SqlServer\IncentiveTemplate;
use App\Swep\Helpers\Arrays;
use App\Swep\Traits\Ownership;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Employee extends Model{

    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id ?? null;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id ?? null;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }

    protected $with = [
        'plantilla',
    ];

    protected $casts = [
        'is_board_member' => 'boolean',
        'deduction_groups' => 'array',
    ];

	use Sortable, LogsActivity;
//	protected $connection = 'server5';
    protected $table = 'hr_employees';
    protected $primaryKey = 'slug';
    public $incrementing = false;
    protected $dates = ['date_of_birth', 'firstday_gov', 'firstday_sra', 'appointment_date', 'adjustment_date', 'created_at', 'updated_at'];

    public $timestamps = true;




    protected $attributes = [
        
        'slug' => '',
        'user_id' => '',
        'project_id' => '',
        'department_id' => '',
        'department_unit_id' => '',
        'employee_no' => '',

        'lastname' => '',
        'firstname' => '',
        'middlename' => '',
        'name_ext' => '',
        'fullname' => '',
        'date_of_birth' => null,
        'place_of_birth' => '',
        'sex' => '',
        'civil_status' => '',
        'height' => '',
        'weight' => '',
        'blood_type' => '',
        'citizenship' => '',
        'citizenship_type' => '',
        'dual_citizenship_country' => '',
        'tel_no' => '',
        'cell_no' => '',
        'email' => '',
        'agency_no' => '',
        'gov_id' => '',
        'license_passport_no' => '',
        'id_date_issue' => '',

        'gsis' => '',
        'philhealth' => '',
        'sss' => '',
        'tin' => '',
        'hdmf' => '',
        'hdmfpremiums' => 0.00,

        'appointment_status' => '',
        'position' => '',
        'item_no' => 0,
        'salary_grade' => 0,
        'step_inc' => 0,
        'monthly_basic' => 0.00,
        'aca' => 0.00,
        'pera' => 0.00,
        'food_subsidy' => 0.00,
        'ra' => 0.00,
        'ta' => 0.00,
        'firstday_gov' => null,
        'firstday_sra' => null,
        'appointment_date' => null,
        'adjustment_date' => null,
        'is_active' => '',

        'created_at' => null, 
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    protected $appends = [
        'full_name','full'
    ];




    use LogsActivity, Ownership;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->table)
            ->logAll()
            ->logExcept([
                'created_at','updated_at','user_updated','user_created','ip_created','ip_updated',
            ])
            ->logOnlyDirty()
            ;
    }


    protected function fullName(): Attribute
    {
        return  new Attribute(
            get: function (){
                if($this->name_ext != null || $this->name_ext != ''){
                    return $this->lastname.', '.$this->firstname.' '.$this->name_ext;
                }
                return $this->lastname.', '.$this->firstname;
            },
        );
    }

    protected function attrAppointmentStatus(): Attribute
    {
        return  new Attribute(
            get: function (){
                if($this->locations == 'VISAYAS' || $this->locations == 'LUZON/MINDANAO'){
                    return 'PERMANENT';
                }
                if($this->locations == 'COS-VISAYAS' || $this->locations == 'COS-LUZMIN'){
                    return 'COS';
                }
                return 'UNDEFINED';
            },
        );
    }


    protected function jgMonthlyBasic():Attribute
    {
        return  new Attribute(
            get: function (){
                $jobGrades = Arrays::jobGrades();
                return $jobGrades[$this->salary_grade][$this->step_inc] ?? $this->monthly_basic;
            },
        );
    }



    protected function full(): Attribute
    {
        return  new Attribute(
            get: function (){
                //LAST FIRST EXT MIDDLE
                $LFEM = $this->lastname.', '.$this->firstname.' '.$this->name_ext.' '.$this->middlename;

                if($this->middlename != '' || $this->middlname != null){
                    $LFEMi = $this->lastname.', '.$this->firstname.' '.$this->name_ext.' '.Str::limit($this->middlename,1,'.');
                }else{
                    $LFEMi = $LFEM;
                }

                $LFE = $this->lastname.', '.$this->firstname.' '.$this->name_ext;

                // FIRST MIDDLE LAST EXT
                $FMLE = $this->firstname.' '.$this->middlename.' '.$this->lastname.' '.$this->name_ext;

                // FIRST MI LAST EXT
                if($this->middlename != '' || $this->middlname != null){
                    if(Str::of($this->middlename)->length() < 2){
                        $mi = $this->middlename.'.';
                    }else{
                        $mi = Str::limit($this->middlename,1,'.');
                    }
                    $FMiLE = $this->firstname.' '.$mi.' '.$this->lastname.' '.$this->name_ext;
                }else{
                    $FMiLE = $FMLE;
                }

                $FLE = $this->firstname.' '.$this->lastname.' '.$this->name_ext;
                return [
                    'LFEM' => rtrim($LFEM),
                    'FMLE' => rtrim($FMLE),
                    'FMiLE' => rtrim($FMiLE),
                    'LFEMi' => rtrim($LFEMi),
                    'LFE' => rtrim($LFE),
                    'FLE' => rtrim($FLE),
                ];
            },
        );
    }

    protected function middleInitial(): Attribute
    {
        return  new Attribute(
            get: function (){
                if($this->middlename != null && $this->middlename != ''){
                    if(strlen($this->middlename) == 1){
                        return $this->middlename.'.';
                    }else{
                        return Str::limit($this->middlename,1,'.');
                    }

                }else{
                    return '';
                }

            },
        );
    }


    protected function leaveBalances(): Attribute
    {
        return  new Attribute(
            get: function (){
                $slug = $this->slug;
                $leaveApplications = LeaveApplication::query()
                    ->selectRaw('charge_to, sum(actual_deduction) as deduct')
                    ->where('employee_slug','=',$slug)
                    ->groupBy('charge_to')
                    ->get();

                $leaveCredits = LeaveCard::query()
                    ->selectRaw('leave_card, sum(credits) as credits, sum(deduction) as deduction, type')
                    ->where('employee_slug','=',$slug)
                    ->groupBy('leave_card','type')
                    ->get();
                $codes = Arrays::leaveTypeCodes();
                $leaveBalances = [];
                foreach ($codes as $code => $name){
                    $leaveBalances[$code] = [
                        'credits' => $leaveCredits->where('type','CREDIT')->where('leave_card',$code)->first()->credits ?? 0,
                        'applications' => $leaveApplications->where('charge_to',$code)->first()->deduct ?? 0,
                        'deductions' => $leaveCredits->where('type','DEDUCTION')->where('leave_card',$code)->first()->deduction ?? 0,
                    ];
                    $leaveBalances[$code]['balance'] =  $leaveBalances[$code]['credits'] - $leaveBalances[$code]['applications'] - $leaveBalances[$code]['deductions'];
                }

                return $leaveBalances;
            },
        );
    }

    protected function incentiveMonthlyBasic(): Attribute
    {
        return  new Attribute(
            get: function (){
                return $this->templateIncentives->where('incentive_code','MONTHLY')->first()->amount ?? 0;
            },
        );
    }
    protected function photoPath(): Attribute{
        $arr = [];
        foreach (Arrays::imageSizes() as $size){
            $arr[$size] = 'symlink/employee_pics/uploaded_'.$size.'/'.$this->photo;
        }
        $arr['original'] = 'symlink/employee_pics/uploaded/'.$this->photo;
        return new Attribute(
            get: fn() =>$arr,
        );
    }




    /** RELATIONSHIPS **/
    public function user() {
        return $this->hasOne(User::class,'employee_slug','slug');
    }

    public function department(){
        return $this->belongsTo('App\Models\Department', 'department_id', 'department_id');
    }

    public function departmentUnit(){
        return $this->belongsTo(DepartmentUnit::class, 'department_unit_id', 'department_unit_id');
    }

    public function project(){
        return $this->belongsTo('App\Models\Project', 'project_id', 'project_id');
    }




    public function employeeAddress(){
        return $this->hasOne(EmployeeAddress::class, 'employee_slug', 'slug');
    } 

    public function employeeFamilyDetail(){
        return $this->hasOne(EmployeeFamilyDetail::class, 'employee_slug', 'slug');
    }

    public function employeeOtherQuestion(){
        return $this->hasOne(EmployeeOtherQuestion::class, 'employee_slug', 'slug');
    }

    public function employeeHealthDeclaration(){
        return $this->hasOne(EmployeeHealthDeclaration::class, 'employee_slug', 'slug');
    }

    public function empBeginningCredits(){
        return $this->hasOne(EmpBeginningCredits::class, 'employee_slug', 'slug');
    }




    public function employeeTraining(){
        return $this->hasMany('App\Models\EmployeeTraining', 'employee_slug', 'slug')->orderBy('sequence_no','desc');
    }

    public function employeeChildren(){
        return $this->hasMany(EmployeeChildren::class, 'employee_slug', 'slug');
    } 

    public function employeeEducationalBackground(){
        return $this->hasMany(EmployeeEducationalBackground::class, 'employee_slug', 'slug');
    }


    public function employeeEligibility(){
        return $this->hasMany(EmployeeEligibility::class, 'employee_slug', 'slug');
    }   

    public function employeeExperience(){
        return $this->hasMany(EmployeeExperience::class, 'employee_slug', 'slug');
    }

    public function employeeOrganization(){
        return $this->hasMany(EmployeeOrganization::class, 'employee_slug', 'slug');
    }

    public function employeeRecognition(){
        return $this->hasMany(EmployeeRecognition::class, 'employee_slug', 'slug');
    }

    public function employeeReference(){
        return $this->hasMany(EmployeeReference::class, 'employee_slug', 'slug');
    }

    public function employeeSpecialSkill(){
        return $this->hasMany(EmployeeSpecialSkill::class, 'employee_slug', 'slug');
    }

    public function employeeVoluntaryWork(){
        return $this->hasMany(EmployeeVoluntaryWork::class, 'employee_slug', 'slug');
    }

    public function employeeMedicalHistories(){
        return $this->hasMany(EmployeeMedicalHistory::class, 'employee_slug', 'slug');
    }


    public function employeeServiceRecord(){
        return $this->hasMany(EmployeeServiceRecord::class, 'employee_slug', 'slug');
    }

    public function employeeMatrix(){
        return $this->hasOne(EmployeeMatrix::class, 'employee_slug', 'slug');
    }

    public function permissionSlip(){
        return $this->hasMany('App\Models\PermissionSlip', 'employee_no', 'employee_no');
    }

    public function leaveCard(){
        return $this->hasMany('App\Models\LeaveCard', 'employee_no', 'employee_no');
    }

    public function documentDisseminationLog(){
        return $this->hasMany(DocumentDisseminationLog::class, 'employee_slug', 'slug');
    }

    public function dtr_records(){
        return $this->hasMany('App\Models\DailyTimeRecord','biometric_user_id','biometric_user_id');
    }

    public function file201s(){
        return $this->hasMany(EmployeeFile201::class,'employee_slug','slug');
    }

    public function responsibilityCenter(){
        return $this->belongsTo(PPURespCodes::class,'resp_center','rc_code');
    }

    public function otherNosa(){
        return $this->hasOne(HrOtherActions::class,'employee_slug','slug')->orderBy('created_at','desc');
    }

    public function leaveBegBal(){
        return $this->hasOne(LeaveBeginningBalance::class,'employee_slug','slug');
    }



    /** Scopes **/
    public function scopeCountBySexAndDeptUnit($query, $dept_unit_id, $sex){

        return $query->whereDepartmentUnitId($dept_unit_id)
                     ->whereSex($sex)
                     ->whereIsActive('ACTIVE')
                     ->get()
                     ->count();

    }




    public function scopeCountBySex($query, $sex){

        return $query->whereSex($sex)
                     ->whereIsActive('ACTIVE')
                     ->get()
                     ->count();

    }




    public function scopeCountByDeptUnit($query, $dept_unit_id){

        return $query->whereDepartmentUnitId($dept_unit_id)
                     ->whereIsActive('ACTIVE')
                     ->get()
                     ->count();
    }




    public function rawDtrRecords(){
        return $this->hasMany(DTR::class,'user','biometric_user_id');
    }
    public function lastRawDtrRecord(){
        return $this->hasOne(DTR::class,'user','biometric_user_id')->orderBy('timestamp','desc');
    }

    public function empMaster(){
        return $this->hasOne(EmpMaster::class,'EmpNo','employee_no');
    }

    public function nonZeroIncentives(){
        return $this->hasMany(TemplateIncentives::class,'employee_slug','slug')
            ->where('amount','!=',0)
            ->where('non_deletable','!=',1)
            ->orderBy('priority','asc');
    }

    public function nonZeroDeductions(){
        return $this->hasMany(TemplateDeductions::class,'employee_slug','slug')
            ->where('amount','!=',0)
            ->whereHas('deduction',function ($q){
                return $q->where('availables','=',1);
            })
            ->orderBy('priority','asc');
    }

    public function incentiveTemplate(){
        return $this->hasMany(IncentiveTemplate::class,'EmpNo','employee_no');
    }

    public function templateIncentives(){
        return $this->hasMany(TemplateIncentives::class,'employee_slug','slug')
//            ->where('non_deletable','!=',1)
            ->orderBy('priority','asc');
    }

    public function templateMonthlyBasic(){
        return $this->hasOne(TemplateIncentives::class,'employee_slug','slug')
                ->where('incentive_code','=','MONTHLY');
    }

    public function templateDeductions(){
        return $this->hasMany(TemplateDeductions::class,'employee_slug','slug')
            ->orderBy('priority','asc');
    }

    public function scopeApplyProjectId(Builder $query){
        $project_id = \Auth::user()->project_id;
        if($project_id == 1) {
            $query->where(function ($q){
                return $q->where('locations','=','VISAYAS')
                    ->orWhere('locations','=','COS-VISAYAS');
            });
        }
        if($project_id == 2){
            $query->where(function ($q){
                return $q->where('locations','=','LUZON/MINDANAO')
                    ->orWhere('locations','=','COS-LUZMIN');
            });
        }
    }

    public function scopeActive(Builder $query){
        $query->where('is_active','=','ACTIVE');
    }



    public function scopePermanent(Builder $query){
        $query->where(function ($q){
            $q->where('locations','=','VISAYAS')
                ->orWhere('locations','=','LUZON/MINDANAO')
                ->orWhere('locations','=','RETIREE');
        });
    }

    public function scopeCos(Builder $query){
        $query->where(function ($q){
            $q->where('locations','!=','VISAYAS')
                ->where('locations','!=','LUZON/MINDANAO');
        });
    }

    public function scopeLuzMin(Builder $query){
            $query->where(function ($q){
                return $q->where('locations','=','LUZON/MINDANAO')
                    ->orWhere('locations','=','COS-LUZMIN');
            });
    }
    public function scopeVis(Builder $query){
        $query->where(function ($q){
            return $q->where('locations','=','VISAYAS')
                ->orWhere('locations','=','COS-VISAYAS');
        });
    }



    public function plantilla(){
        return $this->hasOne(HRPayPlanitilla::class,'item_no','item_no');
    }

    public function payrollSettings()
    {
        return $this->hasOne(PayrollEmployeeSettings::class,'employee_slug','slug');
    }

    public function scopeRemoveBoardMember(Builder $query){
        $query->where('is_board_member','=',null);
    }
    public function scopeReceivesHazardPrc(Builder $builder)
    {
        $builder->whereHas('payrollSettings',function ($payrollSettings){
            $payrollSettings->where('receives_hazard_prc','=',1);
        });
    }

    public function scopeReceivesEitherRaOrTa(Builder $builder)
    {
        $builder->whereHas('payrollSettings',function ($payrollSettings){
            $payrollSettings->where(function ($where){
                $where->where('receives_ra','=',1)
                    ->orWhere('receives_ta','=',1);
            });
        });
    }

    public function amInToday()
    {
        return $this->hasOne(DTR::class,'user','biometric_user_id')
            ->where('timestamp','like',Carbon::now()->format('Y-m-d').'%')
            ->where('type','=',10)
            ->orderBy('timestamp','desc');
    }
}
