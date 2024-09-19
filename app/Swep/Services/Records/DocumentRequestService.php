<?php

namespace App\Swep\Services\Records;

use App\Models\RECORDS\DocumentRequests;
use App\Swep\Repositories\UserSubmenuRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DocumentRequestService
{
    public function __construct(public UserSubmenuRepository $userSubmenuRepository)
    {
    }

    public function newRequestNo()
    {
        $sample = '2024-RF-AUG-001';
        $year = Carbon::now()->format('Y');
        $month = strtoupper(Carbon::now()->format('M'));
        $prefix = $year.'-RF-';
        $controlNo = 0;

        $existingRequest = DocumentRequests::query()
            ->where('request_no','like',$prefix.'%')
            ->orderBy('created_at','desc')
            ->first();
        if(!empty($existingRequest)){
            $controlNo = Str::of($existingRequest->request_no)->afterLast('-')->toInteger();
        }

        $controlNo = Str::of($controlNo + 1)->padLeft(3,'0');
        $newRequestNo = $year.'-RF-'.$month.'-'.$controlNo;

        return $newRequestNo;
    }

    public function authorize($slug,$function)
    {
        if($this->userSubmenuRepository->isUserAuthorized('dashboard.document_request.'.$function)){
            return true;
        }else{
            $documentRequest = DocumentRequests::query()->find($slug);
            if($documentRequest->user_created == Auth::user()->user_id){
                return true;
            }
        }
        abort(403,'You do not have enough privileges to view this data.');
    }


}