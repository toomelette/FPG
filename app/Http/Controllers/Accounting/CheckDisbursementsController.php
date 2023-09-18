<?php

namespace App\Http\Controllers\Accounting;

use App\Enums\AccountingRefBooks;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckDisbursements\CheckDisbursementsFormRequest;
use App\Models\Accounting\JEV;
use App\Models\Accounting\JEVDetails;
use App\Swep\Helpers\Helper;
use App\Swep\Traits\JEVTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CheckDisbursementsController extends Controller
{
    use JEVTrait;
    public function create(){
        return view('dashboard.accounting.check_disbursements.create');
    }

    public function store(CheckDisbursementsFormRequest $request){
        $project_id = Auth::user()->project_id;
        $jev = new JEV();
        $jev->project_id = $project_id;
        $jev->ref_book = AccountingRefBooks::CashDisbursement;
        $jev->slug = Str::random(30);
        $jev->jev_no = $this->newJevNo($request->date);
        $jev->date = $request->date;
        $jev->fund_source = $request->fund_source;
        $jev->payee = $request->payee;
        $jev->cd_no = $request->cd_no;
        $jev->remarks = $request->remarks;
        $jev->check_from = $request->check_from;
        $jev->check_to = $request->check_to;
        $arr = [];
        if(count($request->jev_details) > 0){
            $seq = 1;
            foreach ($request->jev_details as $jev_detail){
                array_push($arr,[
                    'seq_no' => $seq,
                    'project_id' => $project_id,
                    'jev_slug' => $jev->slug,
                    'is_corollary' => 0,
                    'slug' => Str::random(30),
                    'account_code' => $jev_detail['account_code'],
                    'resp_center' => $jev_detail['resp_center'],
                    'jev_debit' => Helper::sanitizeAutonum($jev_detail['debit']),
                    'jev_credit' => Helper::sanitizeAutonum($jev_detail['credit']),
                ]);
                $seq++;
            }
        }
        if(JEVDetails::insert($arr)){
            if($jev->save()){
                return $jev->only('slug');
            }
        }
        abort(503,'Error saving Check Disbursement.');
    }
    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $cashReceipts = JEV::query()->checkDisburmentsOnly();
            return DataTables::of($cashReceipts)
                ->addColumn('details',function($data){

                })
                ->addColumn('action',function($data){
                    return view('dashboard.accounting.check_disbursements.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('date',function($data){
                    return Helper::dateFormat($data->date,'m/d/Y');
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('dashboard.accounting.check_disbursements.index');
    }

    public function edit($slug){
        $checkDisbursement = JEV::query()->where('slug','=',$slug)->first();
        $checkDisbursement ?? abort(503,'Check Disbursement not found.');
        return view('dashboard.accounting.check_disbursements.edit')->with([
            'checkDisbursement' => $checkDisbursement,
        ]);
    }

    public function update(Request $request,$slug){
        $jev = JEV::query()->where('slug','=',$slug)->first();
        $jev ?? abort(503,'Check Disbursement not found.');

        $project_id = Auth::user()->project_id;
        $jev->project_id = $project_id;
        $jev->date = $request->date;
        $jev->fund_source = $request->fund_source;
        $jev->payee = $request->payee;
        $jev->cd_no = $request->cd_no;
        $jev->remarks = $request->remarks;
        $jev->check_from = $request->check_from;
        $jev->check_to = $request->check_to;
        $arr = [];
        if(count($request->jev_details) > 0){
            $seq = 1;
            foreach ($request->jev_details as $jev_detail){
                array_push($arr,[
                    'seq_no' => $seq,
                    'project_id' => $project_id,
                    'jev_slug' => $jev->slug,
                    'is_corollary' => 0,
                    'slug' => Str::random(30),
                    'account_code' => $jev_detail['account_code'],
                    'resp_center' => $jev_detail['resp_center'],
                    'jev_debit' => Helper::sanitizeAutonum($jev_detail['debit']),
                    'jev_credit' => Helper::sanitizeAutonum($jev_detail['credit']),
                ]);
                $seq++;
            }
        }

        $jev->details()->delete();
        if(JEVDetails::insert($arr)){
            if($jev->save()){
                return $jev->only('slug');
            }
        }
        abort(503,'Error saving Check Disbursement.');
    }

    public function destroy($slug){
        $jev = JEV::query()->where('slug','=',$slug)->first();
        $jev ?? abort(503,'JEV not found.');

        if($jev->delete()){
            $jev->details()->delete();
            return 1;
        }
        abort(503,'Error deleting JEV');
    }
}