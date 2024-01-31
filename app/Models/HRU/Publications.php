<?php

namespace App\Models\HRU;

use App\Swep\Services\HRU\PublicationDetailService;
use Illuminate\Database\Eloquent\Model;

class Publications extends Model
{

    public static function boot()
    {
        parent::boot();
        $user = \Auth::user();
        static::updating(function($a) use ($user){
            $a->user_updated = $user->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a) use ($user){
            $a->user_created = $user->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }

    protected $table = 'hr_publications';

    public function publicationDetails(){
        return $this->hasMany(PublicationDetails::class,'publication_slug','slug');
    }

    public function publicationApplicants(){
        return $this->hasManyThrough(
            OApplicants::class,
            PublicationDetails::class,
            'publication_slug',
            'publication_detail_slug',
            'slug',
            'slug'
        );
    }

}