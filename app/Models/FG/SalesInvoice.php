<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id ?? null;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id ?? null;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }
    protected $table = 'sales_invoices';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    /*Relationships*/
    public function details()
    {
        return $this->hasMany(SalesInvoiceDetails::class,'sales_invoice_uuid','uuid');
    }

    public function project()
    {
        return $this->belongsTo(Projects::class,'project_uuid','uuid');
    }
}
