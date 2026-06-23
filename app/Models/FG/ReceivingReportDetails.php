<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Model;

class ReceivingReportDetails extends Model
{
    protected $table = 'receiving_report_details';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function receivingReport()
    {
        return $this->belongsTo(ReceivingReports::class,'receiving_report_uuid','uuid');

        //return $this->hasMany(InventoryLedger::class,'reference_uuid','uuid');
    }

    public function stock()
    {
        return $this->belongsTo(Stocks::class,'stock_uuid','uuid');
    }
}