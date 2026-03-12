<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEmployeeAdjustments extends Model
{
    use HasFactory;

    /* Relationships */

    public function payrollEmployee()
    {
        return $this->belongsTo(PayrollEmployees::class,'payroll_employee_id','id');

    }
}
