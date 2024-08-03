<?php

namespace App\Models\HRU;

use App\Models\LeaveApplication;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicationDates extends Model
{
    protected $table = 'hr_leave_application_dates';

    public function leaveApplication(){
        return $this->belongsTo(LeaveApplication::class,'leave_application_slug','slug');
    }
}