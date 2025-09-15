<?php

namespace App\Models\RECORDS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DMSDocuments extends Model
{
    protected $table = 'swep_afd.rec_dms_docs';

    public function documentFiles()
    {
        return $this->hasMany(DMSFiles::class,'document_slug','slug');
    }

    public function AttachmentFiles()
    {
        return $this->hasMany(DMSAttachment::class,'document_note_slug','slug');
    }
}
