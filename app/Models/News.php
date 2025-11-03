<?php


namespace App\Models;


use App\Models\Scopes\ProjectScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }

    protected $table = 'su_news';
    public $incrementing = false;
    protected $primaryKey = 'slug';

    protected $casts = [
        'viewers' => 'array',
    ];
    public static function booted()
    {
        static::addGlobalScope(new ProjectScope());
    }
    public function attachments(){
        return $this->hasMany(NewsAttachments::class,'news','slug');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('expires_on','>=',Carbon::now());
    }
}