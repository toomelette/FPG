<?php

namespace App\Models\HRU;

use App\Models\Budget\ChartOfAccounts;
use Illuminate\Database\Eloquent\Model;

class PayrollMasterDetails extends Model
{
    protected $table = 'hr_pay_master_details';
    protected $primaryKey = 'slug';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['amount'];

    public function payrollMaster(){
        return $this->belongsTo(PayrollMaster::class,'pay_master_slug','slug');
    }
    public function employeePayroll(){
        return $this->belongsTo(PayrollMasterEmployees::class,'pay_master_employee_listing_slug','slug');
    }

    public function chartOfAccount(){
        return $this->hasOne(ChartOfAccounts::class,'account_code','account_code');
    }

    public function deduction()
    {
        return $this->belongsTo(Deductions::class,'code','deduction_code');
    }

}