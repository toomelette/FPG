<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DocumentDisseminationLog extends Model{


    protected $table = 'rec_document_dissemination_logs';
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_sent = Auth::user()->user_id;
            $a->ip_sent = request()->ip();
            $a->sent_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_sent = Auth::user()->user_id;
            $a->ip_sent = request()->ip();
            $a->sent_at = \Carbon::now();
        });
    }
    protected $dates = ['sent_at'];

	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'document_id' => '',
        'employee_no' => '',
        'email_contact_id' => '',
        'email' => '',
        'subject' => '',
        'content' => '',
        'status' => null,
        'sent_at' => null,
        'ip_sent' => '',
        'user_sent' => '',

    ];


//    public function getTable(){
//        return  'rec_document_dissemination_logs';
//        if(Auth::user()->access == 'QC'){
//            return 'qc_rec_document_dissemination_logs';
//        }
//        if( Auth::user()->access == 'VIS'){
//            return 'rec_document_dissemination_logs';
//        }
//    }

    // Relationships

    public function document(){
        return $this->belongsTo('App\Models\Document', 'document_id', 'document_id');
    }

    public function employee(){
        return $this->belongsTo('App\Models\Employee', 'employee_slug', 'slug');
    }

    public function emailContact(){
        return $this->belongsTo('App\Models\EmailContact', 'email_contact_id', 'email_contact_id');
    }



    
}
