<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollMaster extends Model
{
    use HasFactory;
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
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    /* Relationships */
    public function payrollEmployees()
    {
        return $this->hasMany(PayrollEmployees::class,'payroll_uuid','uuid');
    }
    public function employeeAdjustments()
    {
        return $this->hasManyThrough(
            PayrollEmployeeAdjustments::class, // final model
            PayrollEmployees::class,           // intermediate model
            'payroll_uuid',                    // foreign key on intermediate (PayrollEmployees) pointing to this model (PayrollMaster)
            'payroll_employee_id',             // foreign key on final model (PayrollEmployeeAdjustments) pointing to intermediate
            'uuid',                             // local key on PayrollMaster
            'id'                                // local key on PayrollEmployees
        );
    }
}
