<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PettyCashLiquidationAttachments extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static function booted()
    {
        static::deleting(function ($attachment) {
            if ($attachment->path && Storage::disk('liquidation-attachments')->exists($attachment->path)) {
                Storage::disk('liquidation-attachments')->delete($attachment->path);
            }
        });
    }

    /*Relationships*/
    public function pettyCash()
    {
        return $this->belongsTo(PettyCashLiquidations::class,'petty_cash_liquidation_uuid','uuid');
    }
}
