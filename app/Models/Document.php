<?php

namespace App\Models;

use App\Models\Scopes\ProjectIdScope;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends Model{
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->created_at = \Carbon::now();
        });

        static::creating(function ($a){
            $auth = Auth::user();
            $a->user_created = $auth->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->updated_at = \Carbon::now();
            $a->project_id = $auth->project_id;
        });
    }

    public static function booted()
    {
        static::addGlobalScope(new ProjectIdScope);
    }

    protected $table = 'rec_documents';

    use Sortable, LogsActivity;


    public function getActivitylogOptions():LogOptions {
        return LogOptions::defaults();
    }

    use SoftDeletes;

    protected $dates = ['date', 'created_at', 'updated_at'];

    public $sortable = ['reference_no', 'date', 'person_to', 'person_from', 'subject'];

	public $timestamps = false;

    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at','ip_updated','user_updated'];
    protected static $logOnlyDirty = true;




    protected $attributes = [
        
        'slug' => '',
        'document_id' => '',
        'folder_code' => '',
        'folder_code2' => '',
        'reference_no' => '',
        'date' => null,
        'person_to' => '',
        'person_from' => '',
        'type' => '',
        'subject' => '',
        'category' => '',
        'filename' => '',
        'year' => null,
        'remarks' => '',
        'created_at' => null, 
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    

    // Relationships

    public function documentDisseminationLogAll(){
        return $this->hasMany(DocumentDisseminationLog::class, 'document_id', 'document_id');
    }

    public function documentDisseminationLog(){
        return $this->hasMany(DocumentDisseminationLog::class, 'document_id', 'document_id')
            ->whereNull('send_copy')
            ->orWhere('send_copy','!=',1);
    }


    public function documentDisseminationLogSendCopy(){
        return $this->hasMany('App\Models\DocumentDisseminationLog', 'document_id', 'document_id')->where('send_copy','=', 1);
    }

    public function folder(){
        return $this->belongsTo(DocumentFolder::class , 'folder_code','folder_code');
    }

    public function folder2(){
        return $this->belongsTo(DocumentFolder::class , 'folder_code2','folder_code');
    }

    public function creator(){
        return $this->hasOne("App\Models\User","user_id","user_created");
    }

    public function updater(){
        return $this->hasOne("App\Models\User","user_id","user_updated");
    }

}
