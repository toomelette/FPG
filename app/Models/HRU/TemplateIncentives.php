<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TemplateIncentives extends Model
{
    protected $table = 'hr_pay_template_incentives';
    protected $casts = [
        'amount' => 'float',
    ];
    public $timestamps = false;
    protected $fillable = ['amount','priority'];
    public function incentive(){
        return $this->hasOne(Incentives::class,'incentive_code','incentive_code');
    }

    public function scopeNonZero(Builder $builder){
        $builder->where(function ($q){
            $q->where('amount' ,'!=',0)
                ->orWhere('amount' ,'!=',null);
        });
    }
}