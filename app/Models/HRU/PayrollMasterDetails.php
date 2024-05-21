<?php

namespace App\Models\HRU;

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
}