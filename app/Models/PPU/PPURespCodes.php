<?php


namespace App\Models\PPU;


use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class PPURespCodes extends Model
{
    protected $table = 'budget_resp_codes';
//    protected $connection = 'mysql_ppu';

    public function __construct() {
        $this->table = \DB::connection($this->connection)->getDatabaseName() . '.' . $this->table;
    }

    public function description(){
        return $this->belongsTo(RCDesc::class,'rc','rc');
    }

    public function papCodes(){
        return $this->hasMany(Pap::class,'resp_center','rc_code');
    }

    public function employees(){
        return $this->hasMany(Employee::class,'resp_center','rc_code');
    }

}