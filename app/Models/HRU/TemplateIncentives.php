<?php

namespace App\Models\HRU;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class TemplateIncentives extends Model
{
    protected $table = 'hr_pay_template_incentives';
    protected $casts = [
        'amount' => 'float',
    ];
    public function incentive(){
        return $this->hasOne(Incentives::class,'incentive_code','incentive_code');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_slug','slug');
    }
}