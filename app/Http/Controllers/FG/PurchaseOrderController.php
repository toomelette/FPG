<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\PurchaseOrdersFormRequest;
use App\Models\FG\PurchaseOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    public function __construct(
        private $folder = 'fg-inventory.purchase-order.',
    )
    {
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function store(PurchaseOrdersFormRequest $request)
    {
        $po = new PurchaseOrders();
        $po->uuid = Str::uuid();
        $po->control_no = $request->control_no;
        $po->date = $request->date;
        $po->terms = $request->terms;
        $po->supplier = $request->supplier;
        $po->account_no = $request->account_no;
        $po->remarks = $request->remarks;
        $po->total_amount_due = $request->total_amount_due;
        try {
            DB::transaction(function () use ($po,$request){
                $po->save();
                $po->details()->createMany(collect($request->details)->values()->toArray());});
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $po->only('slug');
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $purchaseOrders = PurchaseOrders::query();
            return DataTables::of($purchaseOrders)
                ->addColumn('action', fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }
    public function edit($uuid)
    {
        $purchaseOrder = PurchaseOrders::query()
            ->with([
                'details.stock'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function update(PurchaseOrdersFormRequest $request,$uuid)
    {
        $purchaseOrder = PurchaseOrders::query()->findOrFail($uuid);
        $purchaseOrder->control_no = $request->control_no;
        $purchaseOrder->date = $request->date;
        $purchaseOrder->terms = $request->terms;
        $purchaseOrder->supplier = $request->supplier;
        $purchaseOrder->account_no = $request->account_no;
        $purchaseOrder->remarks = $request->remarks;
        $purchaseOrder->total_amount_due = $request->total_amount_due;

        try {
            DB::transaction(function () use ($purchaseOrder,$request){
                $purchaseOrder->save();
                $purchaseOrder->details()->delete();
                $purchaseOrder->details()->createMany(collect($request->details)->values()->toArray());
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
    }

    public function destroy($uuid)
    {
        $purchaseOrder = PurchaseOrders::query()->findOrFail($uuid);
        try {
            DB::transaction(function () use ($purchaseOrder){
                $purchaseOrder->delete();
                $purchaseOrder->details()->delete();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return 1;
    }
}
