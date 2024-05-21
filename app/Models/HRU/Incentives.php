<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Incentives extends Model
{
    protected $table = 'hr_pay_incentives';

    public function scopeIsMonthly(Builder $builder){
        $builder->where('n_is_monthly','=',1);
    }

    public function scopeExceptBasicPay(Builder $builder){
        $builder->where('incentive_code','!=','MONTHLY');
    }
}