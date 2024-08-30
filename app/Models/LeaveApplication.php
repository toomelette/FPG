<?php

namespace App\Models;

use App\Models\HRU\LeaveApplicationDates;
use App\Models\PPU\RCDesc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class LeaveApplication extends Model{


    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }


	use Sortable, LogsActivity;

	protected $table = 'hr_leave_application';



	public $timestamps = false;

    protected static $logName = 'leave application';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at','ip_updated','user_updated'];
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions():LogOptions {
        return LogOptions::defaults();
    }








	/** RELATIONSHIPS **/
    public function user(){
        return $this->hasOne('App\Models\User', 'user_id', 'user_id');
    }

    public function dates(){
        return $this->hasMany(LeaveApplicationDates::class,'leave_application_slug','slug')->orderBy('date','asc');
    }

    public function _department(){
        return $this->hasOne(RCDesc::class,'rc','department');
    }

    public function scopeMyData(Builder $query){
        $query->where('user_created','=',\Auth::user()->user_id);
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_slug','slug');
    }

    public function scopeReceived(Builder $query)
    {
        $query->where('status','=','RECEIVED');
    }



}
