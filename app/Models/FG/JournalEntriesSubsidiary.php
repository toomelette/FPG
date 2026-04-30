<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntriesSubsidiary extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;


    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class,'account_code','account_code');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntries::class,'journal_entry_uuid','uuid');
    }
}
