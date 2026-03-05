<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpenseLiquidationDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'description', 'debit', 'credit',
    ];

    /* Relationships */
    public function liquidation()
    {
        return $this->belongsTo(ProjectExpenseLiquidation::class,'project_expense_liquidation_uuid','uuid');
    }
}
