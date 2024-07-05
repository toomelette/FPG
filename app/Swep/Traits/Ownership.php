<?php

namespace App\Swep\Traits;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;



trait Ownership
{

    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class,"user_created","user_id");
    }

    public function updatedBy() : BelongsTo
    {
        return $this->belongsTo(User::class,"user_updated","user_id");
    }

}