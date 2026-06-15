<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpenseLiquidationDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    /* Relationships */
    public function liquidation()
    {
        return $this->belongsTo(ProjectExpenseLiquidation::class,'project_expense_liquidation_uuid','uuid');
    }

    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class,'sales_invoice_uuid','uuid');
    }
}
