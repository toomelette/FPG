<?php

namespace App\Http\Controllers\Accounting;

use App\Enums\AccountingRefBooks;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashDisbursements\CashDisbursementsFormRequest;
use App\Models\Accounting\JEV;
use App\Models\Accounting\JEVDetails;
use App\Swep\Traits\JEVTrait;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CashDisbursementsController extends Controller
{
    use JEVTrait;
    public function create(){
        return view('dashboard.accounting.cash_disbursements.create');
    }

    public function store(CashDisbursementsFormRequest $request){
        $project_id = Auth::user()->project_id;
        $jev = new JEV();
        $jev->project_id = $project_id;
        $jev->ref_book = AccountingRefBooks::CashDisbursements;
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
        abort(510,'Error saving Cash Disbursement.');;
    }

    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $cashReceipts = JEV::query()->cashDisbursementsOnly();
            return DataTables::of($cashReceipts)
                ->addColumn('details',function($data){

                })
                ->addColumn('action',function($data){
                    return view('dashboard.accounting.cash_disbursements.dtActions')->with([
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
        return view('dashboard.accounting.cash_disbursements.index');
    }

    public function edit($slug){
        $cashDisbursement = JEV::query()
            ->where('slug','=',$slug)
            ->cashDisbursementsOnly()
            ->first();
            $cashDisbursement ?? abort(510,'Cash Disbursement not found.');
        return view('dashboard.accounting.cash_disbursements.edit')->with([
            'cashDisbursement' => $cashDisbursement,
        ]);
    }

    public function update(CashDisbursementsFormRequest $request,$slug){
        $jev = JEV::query()
            ->where('slug','=',$slug)
            ->cashDisbursementsOnly()
            ->first();
            $jev ?? abort(510,'Cash Disbursement not found.');

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
        abort(510,'Error saving Cash Disbursement.');
    }

    public function destroy($slug){
        $jev = JEV::query()->where('slug','=',$slug)
            ->cashDisbursementsOnly()
            ->first();
            $jev ?? abort(510,'JEV not found.');

        if($jev->delete()){
            $jev->details()->delete();
            return 1;
        }
        abort(510,'Error deleting JEV');
    }

    public function print($slug){
        $jev = JEV::query()
            ->with(['details.chartOfAccount','corollaryDetails.chartOfAccount','details.department','corollaryDetails.department'])
            ->where('slug','=',$slug)
            ->cashDisbursementsOnly()
            ->first();
            $jev ?? abort(510,'JEV not found.');
        return view('printables.accounting.jev.jev')->with([
            'jev' => $jev,
        ]);
    }

}