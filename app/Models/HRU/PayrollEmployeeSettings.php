<?php

namespace App\Models\HRU;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class PayrollEmployeeSettings extends Model
{
    protected $table = 'hr_pay_employee_settings';

    public $timestamps = false;
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_slug','slug');
    }
}