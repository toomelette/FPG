<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NewsAttachments extends Model
{
    protected $table = 'su_news_attachments';
    protected $primaryKey = 'slug';
    public $incrementing = false;
}