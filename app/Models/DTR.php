<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class DTR extends Model
{
    protected $table = 'hr_dtr';
    public $timestamps = true;

    public $fillable = ['uploaded'];
    protected $casts = [
        'timestamp' => 'datetime',
    ];
    public function deviceDetails(){
        return $this->belongsTo('App\Models\BiometricDevices','device','serial_no');
    }

    public function employeeUnion(){
        $employee = $this->hasOne('App\Models\Employee', 'biometric_user_id', 'user')
            ->select(DB::raw('
                firstname,
                middlename,
                lastname,
                biometric_user_id,
                employee_no,
                date_of_birth as birthday,
                email,
                "PERM" as type
            '));
        $jo_emplyoee = $this->hasOne('App\Models\JoEmployees', 'biometric_user_id', 'user')
            ->select(DB::raw('
                firstname,
                middlename,
                lastname,
                biometric_user_id,
                employee_no,
                birthday,
                email,
                "JO" as type
            '));

        return $employee->union($jo_emplyoee->getQuery());
    }

    public function permanentEmployees(){
        return $this->hasOne('App\Models\Employee','biometric_user_id','user');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'biometric_user_id','user');
    }
}