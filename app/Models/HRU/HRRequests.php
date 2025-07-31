<?php

namespace App\Models\HRU;


use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class HRRequests extends Model
{
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
            $statusCollection = collect($a->status_trail);
            $theSameStatus = $statusCollection->where('status',$a->status)->keys();
            $statusCollection->forget($theSameStatus);
            $statusArray = $statusCollection->toArray();
            $statusArray[] = [
                'timestamp' => \Carbon::now(),
                'status' => $a->status,
                'user' => \Auth::user()->user_id,
            ];

            $a->status_trail = $statusArray;
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
            $a->status = 2;
            $statusArray = $a->status_trail;
            $statusArray[] = [
                'timestamp' => Carbon::now(),
                'status' => $a->status,
                'user' => $a->user_created,
            ];
        });
    }
    protected $table = 'hr_requests';
    public $incrementing = false;
    protected $primaryKey = 'slug';

    protected $casts = [
        'document_fields' => 'array',
        'status_trail' => 'array',
    ];

    /** RELATIONSHIPS */
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_slug','slug');
    }
}