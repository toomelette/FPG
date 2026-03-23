<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPreparationDetails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [
        'id',
    ];
    /* RELATIONSHIPS */
    public function preparation()
    {
        return $this->belongsTo(ProjectPreparations::class,'project_preparation_uuid','uuid');
    }
    public function stock()
    {
        return $this->belongsTo(DeliveryReceipts::class,'stock_uuid','uuid');
    }
}
