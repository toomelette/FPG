<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Model;

class PayrollMaster extends Model
{
    protected $table = 'hr_pay_master';
    protected $primaryKey = 'slug';
    public $incrementing = false;

    public function payrollMasterEmployees(){
        return $this->hasMany(PayrollMasterEmployees::class,'pay_master_slug','slug');
    }

    public function hmtDetails(){
        return $this->hasManyThrough(
            PayrollMasterDetails::class,
            PayrollMasterEmployees::class,
            'pay_master_slug',
            'pay_master_employee_listing_slug',
            'slug',
            'slug'
        );
    }
}