<?php

namespace App\Models;

use App\Models\FG\ProjectPreparations;
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
}
