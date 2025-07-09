<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Model;

class TimekeepingDetails extends Model
{
    protected $table = 'hr_timekeeping_details';
    protected $primaryKey = 'slug';
    public $incrementing = false;
    public $timestamps = false;

    public function timekeeping()
    {
        return $this->belongsTo(Timekeeping::class,'timekeeping_slug','slug');
    }
}