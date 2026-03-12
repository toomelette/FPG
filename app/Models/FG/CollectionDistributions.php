<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionDistributions extends Model
{
    use HasFactory;

    protected $guarded = ['collection_uuid'];
    public $timestamps = false;



    /* Relationships */

    public function collection()
    {
        return $this->belongsTo(Collections::class,'collection_uuid','uuid');
    }
}
