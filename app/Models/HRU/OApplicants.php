<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OApplicants extends Model
{
    protected $table = 'hr_o_applicants';

    public function educationalBackground(){
        return $this->hasMany(OApplicantEducation::class,'applicant_slug','slug');
    }
    public function eligibilities(){
        return $this->hasMany(OApplicantEligibility::class,'applicant_slug','slug');
    }
    public function workExperiences(){
        return $this->hasMany(OApplicantWork::class,'applicant_slug','slug')
            ->orderBy('from','desc');
    }
    public function trainings(){
        return $this->hasMany(OApplicantTraining::class,'applicant_slug','slug');
    }

    public function publicationItem(){
        return $this->belongsTo(PublicationDetails::class,'publication_detail_slug','slug');
    }

    public function scopeFinalized(Builder $query){
        $query->where('status' ,'=','FINALIZED');
    }
}