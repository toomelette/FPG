<?php


namespace App\Models\PPU;


use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

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


    use HasRecursiveRelationships;
    public function getLocalKeyName()
    {
        return 'rc_code';
    }

    public function getParentKeyName()
    {
        return 'parent_rc_code';
    }
}