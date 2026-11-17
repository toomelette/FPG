<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostingFolders extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';


    public function children()
    {
        return $this->hasMany(CostingFolders::class,'parent_folder_uuid','uuid');
    }

    public function scopeChildrenOnly(Builder $builder)
    {
        $builder->whereNotNull('parent_folder_uuid');
    }

    public function scopeParentsOnly(Builder $builder)
    {
        $builder->whereNull('parent_folder_uuid');
    }

    public function costings()
    {
        return $this->hasMany(Costings::class,'folder_uuid','uuid');
    }
}

