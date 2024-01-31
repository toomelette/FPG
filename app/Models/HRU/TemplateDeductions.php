<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Model;

class TemplateDeductions extends Model
{
    protected $table = 'hr_pay_template_deductions';

    public function deduction(){
        return $this->hasOne(Deductions::class,'deduction_code','deduction_code');
    }
}