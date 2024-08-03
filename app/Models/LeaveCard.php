<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class LeaveCard extends Model{


	use Sortable, LogsActivity;

	protected $table = 'hr_leave_card';

    protected $dates = ['date', 'date_from', 'date_to', 'created_at', 'updated_at'];

	public $timestamps = false;

    protected static $logName = 'leave card';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at','ip_updated','user_updated'];
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions():LogOptions {
        return LogOptions::defaults();
    }






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }




    /** Scopes **/
    public function scopeGetTardy($query, $month, $year){

        return $query->select('credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'TARDY')
                     ->get();

    }





    public function scopeGetUndertime($query, $month, $year){

        return $query->select('credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'UT')
                     ->get();

    }





    public function scopeGetLeave($query, $month, $year){

        return $query->select('leave_type', 'date_from', 'date_to', 'days')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'LEAVE')
                     ->get();

    }





    public function scopeGetLeaveVacation($query, $month, $year){

        return $query->select('leave_type', 'date_from', 'date_to', 'days', 'credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'LEAVE')
                     ->where('leave_type', 'VL')
                     ->get();

    }





    public function scopeGetLeaveSick($query, $month, $year){

        return $query->select('leave_type', 'date_from', 'date_to', 'days', 'credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'LEAVE')
                     ->where('leave_type', 'SL')
                     ->get();

    }





    public function scopeGetLeaveForced($query, $month, $year){

        return $query->select('leave_type', 'date_from', 'date_to', 'days', 'credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'LEAVE')
                     ->where('leave_type', 'FL')
                     ->get();

    }





    public function scopeGetMonitize($query, $month, $year, $charge){

        return $query->select('leave_type', 'date', 'date_from', 'date_to', 'days', 'credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'MON')
                     ->where('charge_to', $charge)
                     ->get();

    }





    public function scopeGetOvertime($query, $month, $year){

        return $query->select('leave_type', 'date', 'credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'OT')
                     ->get();

    }





    public function scopeGetCompensatory($query, $month, $year){

        return $query->select('leave_type', 'date', 'credits')
                     ->where('month', $month)
                     ->where('year', $year)
                     ->where('doc_type', 'COM')
                     ->get();

    }





    
}
