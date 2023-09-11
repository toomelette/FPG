<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\JEV;
use App\Models\Accounting\JEVDetails;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CashReceiptsController extends Controller
{
    public function create(){
        return view('dashboard.accounting.cash_receipts.create');
    }

    public function store(Request $request){
        $project_id = Auth::user()->project_id;
        $jev = new JEV();
        $jev->project_id = $project_id;
        $jev->slug = Str::random(30);
        $jev->date = $request->date;
        $jev->fund_source = $request->fund_source;
        $jev->collecting_officer = $request->collecting_officer;
        $jev->rcd_no = $request->rcd_no;
        $jev->remarks = $request->remarks;
        $arr = [];
        if(count($request->jev_details) > 0){

            foreach ($request->jev_details as $jev_detail){
                array_push($arr,[
                    'project_id' => $project_id,
                    'jev_slug' => $jev->slug,
                    'is_corollary' => 0,
                    'slug' => Str::random(30),
                    'account_code' => $jev_detail['account_code'],
                    'resp_center' => $jev_detail['resp_center'],
                    'jev_debit' => Helper::sanitizeAutonum($jev_detail['debit']),
                    'jev_credit' => Helper::sanitizeAutonum($jev_detail['credit']),
                ]);
            }
        }


        if(count($request->corollary_accounts) > 0){
            foreach ($request->corollary_accounts as $corollary_account){
                array_push($arr,[
                    'project_id' => $project_id,
                    'jev_slug' => $jev->slug,
                    'slug' => Str::random(30),
                    'is_corollary' => 1,
                    'account_code' => $corollary_account['account_code'],
                    'resp_center' => $corollary_account['resp_center'],
                    'jev_debit' => Helper::sanitizeAutonum($corollary_account['debit']),
                    'jev_credit' => Helper::sanitizeAutonum($corollary_account['credit']),
                ]);
            }
        }
        if(JEVDetails::insert($arr)){
            if($jev->save()){
                return $jev->only('slug');
            }
        }
        abort(503,'Error saving Cash Receipt');
    }
}