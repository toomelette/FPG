<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DailyTimeRecord extends Model
{
    protected $table = 'hr_daily_time_records';

    protected $attributes = [
        'am_in' => null,
        'am_out' => null,
        'pm_in' => null,
        'pm_out' => null,
        'ot_in' => null,
        'ot_out' => null,
    ];

    public function edits(){
        return $this->hasMany(DTREdits::class,'dtr_slug','slug');
    }

    public function remarksUpdater(){
        return $this->hasOne(User::class,"user_id","remarks_user_updated");
    }

}