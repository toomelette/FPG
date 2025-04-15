<?php

namespace App\Models\RBAC;

use App\Models\PPUV\Suppliers;
use Illuminate\Database\Eloquent\Model;

class EvaluationOffers extends Model
{
    protected $table = 'rbac_evaluation_offers';
    public $timestamps = false;

    public function relSupplier()
    {
        return $this->hasOne(Suppliers::class,'slug','supplier_slug');
    }
}