<?php

namespace App\Models;

use App\Models\HRU\HrOtherActions;
use App\Models\HRU\LeaveBeginningBalance;
use App\Models\HRU\TemplateDeductions;
use App\Models\HRU\TemplateIncentives;
use App\Models\PPU\PPURespCodes;
use App\Models\SqlServer\EmpMaster;
use App\Models\SqlServer\IncentiveTemplate;
use App\Swep\Helpers\Arrays;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Employee extends Model{

    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }




	use Sortable, LogsActivity;
//	protected $connection = 'mysql_qc_server';
    protected $table = 'hr_employees';
    protected $primaryKey = 'slug';
    public $incrementing = false;
    protected $dates = ['date_of_birth', 'firstday_gov', 'firstday_sra', 'appointment_date', 'adjustment_date', 'created_at', 'updated_at'];

    public $timestamps = true;

    protected static $logName = 'employee';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at','ip_updated','user_updated'];
    protected static $logOnlyDirty = true;



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

    protected $guarded = ['id','slug'];

    protected function fullName(): Attribute
    {
        return  new Attribute(
            get: fn() => $this->lastname.', '.$this->firstname,
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


    public function getActivitylogOptions():LogOptions {
        return LogOptions::defaults();
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
        return $this->hasMany(EmployeeServiceRecord::class, 'employee_slug', 'slug')->orderBy('sequence_no','asc');
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


}
