<?php

namespace App\Models\HRU;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class COSEmployees extends Model
{
    protected $table = 'hr_cos_employees';
    protected $primaryKey = 'hr_cos_employees_slug';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'other_data' => 'array',
        'logs' => 'array',
    ];

    public function cos()
    {
        return $this->belongsTo(COS::class,'cos_slug','slug');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class,'slug','employee_slug');
    }
}