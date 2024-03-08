<?php


namespace App\Models;


use App\Models\PPU\RCDesc;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MisRequests extends Model
{
    public $table = 'mis_requests';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($menu){
            $menu->user_created = Auth::user()->user_id;
            $menu->ip_created = request()->ip();
        });

        static::updating(function ($menu){
            $menu->user_updated = Auth::user()->user_id;
            $menu->ip_updated = request()->ip();
        });
    }

    public function creator(){
        return $this->hasOne("App\Models\User","user_id","user_created");
    }

    public function updater(){
        return $this->hasOne("App\Models\User","user_id","user_updated");
    }

    public function status(){
        return $this->hasMany('App\Models\MisRequestsStatus','request_slug','slug')->orderBy('created_at','desc');
    }

    public function user(){
        return $this->belongsTo(User::class,'requisitioner','user_id');
    }

    public function dept(){
        return $this->belongsTo(RCDesc::class,'department','rc');
    }

}