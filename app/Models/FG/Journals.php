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
        'date' => 'date',
    ];

    /*Relationships*/
    public function entries()
    {
        return $this->hasMany(JournalEntries::class,'journal_uuid','uuid');
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
