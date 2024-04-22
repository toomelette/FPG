<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\Traits\LogsActivity;

class DocumentFolder extends Model{


//	use Sortable,LogsActivity;

    protected $table = 'rec_document_folders';

    protected $dates = ['created_at', 'updated_at'];

    public $sortable = ['folder_code', 'description'];

	public $timestamps = false;


//    protected static $logName = 'document folder';
//    protected static $logAttributes = ['*'];
//    protected static $ignoreChangedAttributes = ['updated_at','ip_updated','user_updated'];
//    protected static $logOnlyDirty = true;

    protected $attributes = [
        
        'slug' => '',
        'folder_code' => '',
        'description' => '',
        'created_at' => null, 
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',


    ];

    public function getTable(){
        $user_access = 'VIS';
        if( $user_access == 'QC'){
            return 'qc_rec_document_folders';
        }elseif(  $user_access == 'VIS'){
            return 'rec_document_folders';
        }
    }


    public function documents1(){
        return $this->hasMany('App\Models\Document','folder_code','folder_code');
    }

    public function documents2(){
        return $this->hasMany('App\Models\Document','folder_code2','folder_code');
    }
    
}
