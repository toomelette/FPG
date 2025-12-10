<?php

namespace App\Models\HRU;

use App\Models\Employee;
use App\Models\PPU\PPURespCodes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\Relations\HasOneJson;

class PayrollMasterEmployees extends Model
{


    protected $table = 'hr_pay_master_employees';
    public $timestamps = false;
    protected $primaryKey = 'slug';
    public $incrementing = false;

    protected $casts = [
            'saved_employee_data' => 'array',
            'has_been_edited' => 'array',
            'diff_other' => 'array',
        ];
    public function payrollMaster(){
        return $this->belongsTo(PayrollMaster::class,'pay_master_slug','slug');
    }
    public function employeePayrollDetails(){
        return $this->hasMany(PayrollMasterDetails::class,'pay_master_employee_listing_slug','slug');
    }

    public function employeePayrollDetailsIncentives(){
        return $this
            ->hasMany(PayrollMasterDetails::class,'pay_master_employee_listing_slug','slug')
            ->where('type','=','INCENTIVE');
    }

    public function employeePayrollDetailsDeductions(){
        return $this
            ->hasMany(PayrollMasterDetails::class,'pay_master_employee_listing_slug','slug')
            ->where('type','=','DEDUCTION');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'slug','employee_slug');
    }

    protected function totals(): Attribute
    {
        $incentive = $this->employeePayrollDetails->where('type','=','INCENTIVE')->sum('amount');
        $deduction = $this->employeePayrollDetails->where('type','=','DEDUCTION')->sum('amount');
        return  new Attribute(
            get: fn() => [
                'incentive' => $incentive,
                'deduction' => $deduction,
                'takeHomePay' => $incentive - $deduction,
            ],
        );
    }


}