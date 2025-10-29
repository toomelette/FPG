<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    protected $table = 'su_news';
    public $incrementing = false;
    protected $primaryKey = 'slug';

    public function attachments(){
        return $this->hasMany(NewsAttachments::class,'news','slug');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('expires_on','>=',Carbon::now());
    }
}