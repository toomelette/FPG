<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Holiday extends Model
{
    use LogsActivity;

    protected $table = 'hr_holidays';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($data){
            $data->user_created = Auth::user()->user_id;
            $data->ip_created = request()->ip();
        });

        static::updating(function ($data){
            $data->user_updated = Auth::user()->user_id;
            $data->ip_updated = request()->ip();
        });
    }

    protected static $logName = 'holiday';
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at','ip_updated','user_updated'];
    protected static $logOnlyDirty = true;
    protected $primaryKey = 'slug';
    public $incrementing = false;
    public function getActivitylogOptions():LogOptions {
        return LogOptions::defaults();
    }

    protected $attributes = [
        'slug' => '',
        'name' => '',
        'date' => null,
        'type' => '',
        'google_calendar_id' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',
    ];

}