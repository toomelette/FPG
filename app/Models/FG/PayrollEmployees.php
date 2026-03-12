<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEmployees extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'saved_data' => 'array',
    ];
    /* Relationships */
    public function payrollMaster()
    {
        return $this->belongsTo(PayrollMaster::class,'payroll_uuid','uuid');
    }
    public function employeeAdjustments()
    {
        return $this->hasMany(PayrollEmployeeAdjustments::class,'payroll_employee_id','id');
    }
}
