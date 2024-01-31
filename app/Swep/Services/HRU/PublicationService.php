<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\Publications;

class PublicationService
{
    public function findBySlug($slug){
        $pub = Publications::query()->with(['publicationDetails.applicants'])

            ->where('slug','=',$slug)
            ->first();
        return $pub ?? abort(503,'Publication not found.');
    }
}