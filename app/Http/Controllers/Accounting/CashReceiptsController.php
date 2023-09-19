<?php

namespace App\Http\Controllers\Accounting;

use App\Enums\AccountingRefBooks;
use App\Http\Controllers\Controller;
use App\Http\Requests\CashReceipts\CashReceiptsFormRequest;
use App\Models\Accounting\JEV;
use App\Models\Accounting\JEVDetails;
use App\Swep\Helpers\Helper;
use App\Swep\Services\Accounting\CashReceiptsService;
use App\Swep\Traits\JEVTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CashReceiptsController extends Controller
{
    use JEVTrait;
    public function __construct(
        protected CashReceiptsService $cashReceiptsService,
    )
    {

    }

    public function create(){

        return view('dashboard.accounting.cash_receipts.create');
    }

    public function store(CashReceiptsFormRequest $request){

        $project_id = Auth::user()->project_id;
        $jev = new JEV();
        $jev->project_id = $project_id;
        $jev->ref_book = AccountingRefBooks::CashReceipt;
        $jev->slug = Str::random(30);
        $jev->jev_no = $this->newJevNo($request->date);
        $jev->date = $request->date;
        $jev->fund_source = $request->fund_source;
        $jev->collecting_officer = $request->collecting_officer;
        $jev->rcd_no = $request->rcd_no;
        $jev->remarks = $request->remarks;
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
        if(!empty($request->corollary_accounts) && count($request->corollary_accounts) > 0){
            $seq = 1;
            foreach ($request->corollary_accounts as $corollary_account){
                array_push($arr,[
                    'seq_no' => $seq,
                    'project_id' => $project_id,
                    'jev_slug' => $jev->slug,
                    'slug' => Str::random(30),
                    'is_corollary' => 1,
                    'account_code' => $corollary_account['account_code'],
                    'resp_center' => $corollary_account['resp_center'],
                    'jev_debit' => Helper::sanitizeAutonum($corollary_account['debit']),
                    'jev_credit' => Helper::sanitizeAutonum($corollary_account['credit']),
                ]);
                $seq++;
            }
        }

        if(JEVDetails::insert($arr)){
            if($jev->save()){
                return $jev->only('slug');
            }
        }
        abort(510,'Error saving Cash Receipt');
    }

    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $cashReceipts = JEV::query()->cashReceiptsOnly();
            return DataTables::of($cashReceipts)
                ->addColumn('details',function($data){

                })
                ->addColumn('action',function($data){
                    return view('dashboard.accounting.cash_receipts.dtActions')->with([
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
        return view('dashboard.accounting.cash_receipts.index');
    }

    public function edit($slug){
        return view('dashboard.accounting.cash_receipts.edit')->with([
            'cashReceipt' => $this->cashReceiptsService->findBySlug($slug),
        ]);
    }

    public function update(CashReceiptsFormRequest $request, $slug){
        $jev = JEV::query()->where('slug','=',$slug)
            ->cashReceiptsOnly()
            ->first();
        $jev ?? abort(510,'JEV not found.');

        $project_id = Auth::user()->project_id;
        $jev->project_id = $project_id;
        $jev->date = $request->date;
        $jev->fund_source = $request->fund_source;
        $jev->collecting_officer = $request->collecting_officer;
        $jev->rcd_no = $request->rcd_no;
        $jev->remarks = $request->remarks;
        $jev->remarks2 = $request->remarks2;
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
        if(!empty($request->corollary_accounts) && count($request->corollary_accounts) > 0){
            $seq = 1;
            foreach ($request->corollary_accounts as $corollary_account){
                array_push($arr,[
                    'seq_no' => $seq,
                    'project_id' => $project_id,
                    'jev_slug' => $jev->slug,
                    'slug' => Str::random(30),
                    'is_corollary' => 1,
                    'account_code' => $corollary_account['account_code'],
                    'resp_center' => $corollary_account['resp_center'],
                    'jev_debit' => Helper::sanitizeAutonum($corollary_account['debit']),
                    'jev_credit' => Helper::sanitizeAutonum($corollary_account['credit']),
                ]);
                $seq++;
            }
        }

        $jev->details()->delete();
        $jev->corollaryDetails()->delete();
        if(JEVDetails::insert($arr)){
            if($jev->save()){
                return $jev->only('slug');
            }
        }
        abort(510,'Error saving Cash Receipt');
    }

    public function destroy($slug){
        $jev = JEV::query()->where('slug','=',$slug)
            ->cashReceiptsOnly()
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
            ->with(['details.chartOfAccount','corollaryDetails.chartOfAccount'])
            ->where('slug','=',$slug)
            ->cashReceiptsOnly()
            ->first();
        $jev ?? abort(510,'JEV not found.');
        return view('printables.accounting.jev.jev')->with([
            'jev' => $jev,
        ]);
    }
}