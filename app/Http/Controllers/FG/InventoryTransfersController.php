<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\InventoryTransfersFormRequest;
use App\Models\FG\InventoryTransfers;
use App\Models\FG\ReceivingReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class InventoryTransfersController extends Controller
{
    public function __construct(
        private $folder = 'fg-inventory.inventory-transfer.',
    )
    {
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function store(InventoryTransfersFormRequest $request)
    {
        $inventoryTransfer = new InventoryTransfers();
        $inventoryTransfer->uuid = Str::uuid();
        $inventoryTransfer->control_no = $request->control_no;
        $inventoryTransfer->date = $request->date;
        $inventoryTransfer->transfer_from = $request->transfer_from;
        $inventoryTransfer->transfer_to = $request->transfer_to;
        $inventoryTransfer->remarks = $request->remarks;


        try {
            DB::transaction(function () use ($inventoryTransfer,$request){
                $inventoryTransfer->save();
                $inventoryTransfer->details()->createMany(collect($request->details)->values()->toArray());
                $inventoryTransfer->inventoryLedger()->createMany($request->inventory_ledger);
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $inventoryTransfer->only('uuid');
    }

    public function index(Request $request)
    {
        $rrs = InventoryTransfers::query();
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
        $inventoryTransfer = InventoryTransfers::query()
            ->with([
                'details.stock'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'inventoryTransfer' => $inventoryTransfer
        ]);
    }

    public function update(InventoryTransfersFormRequest $request,$uuid)
    {
        $inventoryTransfer = InventoryTransfers::query()->findOrFail($uuid);
        $inventoryTransfer->control_no = $request->control_no;
        $inventoryTransfer->date = $request->date;
        $inventoryTransfer->transfer_from = $request->transfer_from;
        $inventoryTransfer->transfer_to = $request->transfer_to;
        $inventoryTransfer->remarks = $request->remarks;

        try {
            DB::transaction(function () use ($inventoryTransfer,$request){
                $inventoryTransfer->save();
                $inventoryTransfer->details()->delete();
                $inventoryTransfer->inventoryLedger()->delete();
                $inventoryTransfer->details()->createMany(collect($request->details)->values()->toArray());
                $inventoryTransfer->inventoryLedger()->createMany($request->inventory_ledger);
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $inventoryTransfer->only('slug');
    }

    public function destroy($uuid)
    {
        $inventoryTransfer = InventoryTransfers::query()->findOrFail($uuid);
        try {
            DB::transaction(function () use ($inventoryTransfer){
                $inventoryTransfer->delete();
                $inventoryTransfer->details()->delete();
                $inventoryTransfer->inventoryLedger()->delete();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return 1;
    }

}
