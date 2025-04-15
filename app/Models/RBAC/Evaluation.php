<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'rbac_evaluation';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'slug';

    public function offers()
    {
        return $this->hasMany(EvaluationOffers::class,'evaluation_slug','slug');
    }
}