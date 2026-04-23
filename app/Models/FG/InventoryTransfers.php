<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransfers extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }

    /*Relationships*/
    public function details()
    {
        return $this->hasMany(InventoryTransferDetails::class,'inventory_transfer_uuid','uuid');
    }
    public function inventoryLedger()
    {
        return $this->hasMany(InventoryLedger::class,'reference_uuid','uuid')
            ->where('reference_type','INVENTORY TRANSFER');
    }
}
