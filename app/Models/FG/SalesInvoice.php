<?php

namespace App\Models\FG;

use App\Models\Scopes\FG\ProjectIdScope;
use Illuminate\Database\Eloquent\Builder;
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
            $a->project_id = \Auth::user()->project_id;
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id ?? null;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }
    protected $table = 'sales_invoices';

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::addGlobalScope(new ProjectIdScope());
    }

    /*Relationships*/

    public function details()
    {
        return $this->hasMany(SalesInvoiceDetails::class,'sales_invoice_uuid','uuid');
    }

    public function inventoryLedger()
    {
        return $this->hasMany(InventoryLedger::class,'reference_uuid','uuid')
            ->where('reference_type','SALES INVOICE');
    }
    public function client()
    {
        return $this->belongsTo(Clients::class,'client_uuid','uuid');
    }

    public function liquidations()
    {
        return $this->hasMany(ProjectExpenseLiquidation::class,'invoice_uuid','uuid');
    }

    public function liquidationDetails()
    {
        return $this->hasMany(ProjectExpenseLiquidationDetails::class,'sales_invoice_uuid','uuid');
    }

    public function distributions()
    {
        return $this->hasMany(CollectionDistributions::class,'invoice_uuid','uuid');
    }

    public function preparations()
    {
        return $this->hasMany(ProjectPreparations::class,'invoice_uuid','uuid');
    }
    public function deliveries()
    {
        return $this->hasMany(DeliveryReceipts::class,'invoice_uuid','uuid');
    }


    /*Scopes*/
    public function scopeCashInvoices(Builder $builder)
    {
        $builder->where('ref_book','=','CASH');
    }
    public function scopeChargeInvoices(Builder $builder)
    {
        $builder->where('ref_book','=','CHARGE');
    }
    public function scopeBillings(Builder $builder)
    {
        $builder->where('ref_book','=','BILLING');
    }
}
