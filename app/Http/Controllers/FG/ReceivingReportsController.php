<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ReceivingReportsFormRequest;
use App\Models\FG\PurchaseOrders;
use App\Models\FG\ReceivingReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ReceivingReportsController extends Controller
{
    public function __construct(
        private $folder = 'fg-inventory.receiving-report.',
    )
    {
    }



    public function create(Request $request)
    {
        if($request->has('getPo')){
            $poNo = $request->poNo;
            $po = PurchaseOrders::query()
                ->with(['details.stock'])
                ->where('control_no','=',$poNo)
                ->first();
            if(filled($po)){
                return $po;
            }else{
                return [];
            }
        }
        return view($this->folder.'create');
    }

    public function store(ReceivingReportsFormRequest $request)
    {
        $rr = new ReceivingReports();
        $rr->uuid = Str::uuid();
        $rr->control_no = $request->control_no;
        $rr->date = $request->date;
        $rr->po_no = $request->po_no;
        $rr->terms = $request->terms;
        $rr->account_no = $request->account_no;
        $rr->inv_dr_no = $request->inv_dr_no;
        $rr->remarks = $request->remarks;
        $rr->total_amount_due = $request->total_amount_due;
        $rr->ewt = $request->ewt;
        $rr->ap = $request->ap;

        try {
            DB::transaction(function () use ($rr,$request){
                $rr->save();
                $rr->details()->createMany(collect($request->details)->values()->toArray());
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
    }

    public function index(Request $request)
    {
        $rrs = ReceivingReports::query();
        if($request->ajax() && $request->has('draw')){
            return DataTables::of($rrs)
                ->addColumn('action', fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function edit($uuid)
    {
        $receivingReport = ReceivingReports::query()
            ->with([
                'details.stock'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'receivingReport' => $receivingReport
        ]);
    }

    public function update(ReceivingReportsFormRequest $request,$uuid)
    {
        $rr = ReceivingReports::query()->findOrFail($uuid);
        $rr->control_no = $request->control_no;
        $rr->date = $request->date;
        $rr->po_no = $request->po_no;
        $rr->terms = $request->terms;
        $rr->account_no = $request->account_no;
        $rr->inv_dr_no = $request->inv_dr_no;
        $rr->remarks = $request->remarks;
        $rr->total_amount_due = $request->total_amount_due;
        $rr->ewt = $request->ewt;
        $rr->ap = $request->ap;

        try {
            DB::transaction(function () use ($rr,$request){
                $rr->save();
                $rr->details()->delete();
                $rr->details()->createMany(collect($request->details)->values()->toArray());
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
    }

    public function destroy($uuid)
    {
        $rr = ReceivingReports::query()->findOrFail($uuid);
        try {
            DB::transaction(function () use ($rr){
                $rr->delete();
                $rr->details()->delete();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return 1;
    }
}
