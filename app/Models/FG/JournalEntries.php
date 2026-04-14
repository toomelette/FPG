<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntries extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    /*Relationships*/
    public function journal()
    {
        return $this->belongsTo(Journals::class,'journal_uuid','uuid');
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class,'account_code','account_code');
    }
}
