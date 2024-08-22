<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TemplateDeductions extends Model
{
    protected $table = 'hr_pay_template_deductions';
    protected $casts = [
        'amount' => 'float',
    ];

    protected $fillable = [
        'govt_share',
        'ec_share',
        ];
    public $timestamps = false;
    public function deduction(){
        return $this->hasOne(Deductions::class,'deduction_code','deduction_code');
    }
    public function scopeNonZero(Builder $builder){
        $builder->where(function ($q){
            $q->where('amount' ,'!=',0)
                ->orWhere('amount' ,'!=',null);
        });
    }
}