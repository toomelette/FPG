<?php

namespace App\Models\HRU;

use App\Models\Budget\ChartOfAccounts;
use App\Models\Scopes\ProjectScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PayrollMaster extends Model
{
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }
    public static function booted()
    {
        static::addGlobalScope(new ProjectScope());
    }

    protected $table = 'hr_pay_master';
    protected $primaryKey = 'slug';
    public $incrementing = false;
    protected $casts = [
        'other_details' => 'array',
    ];

    public function payrollMasterEmployees(){
        return $this->hasMany(PayrollMasterEmployees::class,'pay_master_slug','slug');
    }

    public function hmtDetails(){
        return $this->hasManyThrough(
            PayrollMasterDetails::class,
            PayrollMasterEmployees::class,
            'pay_master_slug',
            'pay_master_employee_listing_slug',
            'slug',
            'slug'
        );
    }


    public function chartOfAccounts(){
        return $this->hasOne(ChartOfAccounts::class,'account_code','account_code');
    }
}