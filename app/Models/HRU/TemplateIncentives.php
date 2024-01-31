<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Model;

class TemplateIncentives extends Model
{
    protected $table = 'hr_pay_template_incentives';

    public function incentive(){
        return $this->hasOne(Incentives::class,'incentive_code','incentive_code');
    }
}