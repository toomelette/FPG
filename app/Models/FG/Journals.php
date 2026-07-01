<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        //'date' => 'date',
    ];

    /*Relationships*/
    public function entries()
    {
        return $this->hasMany(JournalEntries::class,'journal_uuid','uuid');
    }
    public function entriesSubsidiaries()
    {
        return $this->hasManyThrough(
            JournalEntriesSubsidiary::class, // Final model
            JournalEntries::class,           // Intermediate model
            'journal_uuid',                  // FK on JournalEntries (points to Journals.uuid)
            'journal_entry_uuid',            // FK on Subsidiary (points to JournalEntries.uuid)
            'uuid',                          // Local key on Journals
            'uuid'                           // Local key on JournalEntries
        );
    }

    public function collection()
    {
        return $this->hasOne(Collections::class,'uuid','collection_uuid');
    }


    /*Scopes*/
    public function scopeCashDisbursements(Builder $builder)
    {
        $builder->where('book','=','CASH DISBURSEMENT');
    }

    public function scopeCashReceipts(Builder $builder)
    {
        $builder->where('book','=','CASH RECEIPT');
    }

    public function scopeGeneralJournals(Builder $builder)
    {
        $builder->where('book','=','GENERAL JOURNAL');
    }


}
