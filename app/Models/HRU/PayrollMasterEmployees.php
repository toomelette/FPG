<?php

namespace App\Models\HRU;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class PayrollMasterEmployees extends Model
{
    protected $table = 'hr_pay_master_employees';
    public $timestamps = false;

    public function payrollMaster(){
        return $this->belongsTo(PayrollMaster::class,'payroll_master_slug','slug');
    }
    public function employeePayrollDetails(){
        return $this->hasMany(PayrollMasterDetails::class,'pay_master_employee_listing_slug','slug');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'slug','employee_slug');
    }
}