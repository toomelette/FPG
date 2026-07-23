<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\DeliveryReceiptsFormRequest;
use App\Models\FG\DeliveryReceipts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DeliveryReceiptsController extends Controller
{
    public function __construct(
        private $folder = 'fg.delivery-receipts.'
    )
    {
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $drs = DeliveryReceipts::query()->with([
                    'invoice.client',
                    'details',
                ])
                ->withSum('details','amount');
            return DataTables::of($drs)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('control_no',fn($data) => view($this->folder.'dt-control-no')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function create()
    {
        return view($this->folder.'create');
    }
    public function store(DeliveryReceiptsFormRequest $request)
    {
        $dr = new DeliveryReceipts();
        $dr->uuid = Str::uuid();
        $dr->control_no = $request->control_no;
        $dr->invoice_uuid = $request->invoice_uuid;
        $dr->temp_name = $request->temp_name;
        $dr->type = $request->type;
        $dr->date = $request->date;
        $dr->terms = $request->terms;
        $dr->remarks = $request->remarks;
        $details = collect($request->details)->values();
        try {
            DB::transaction(function () use ($dr,$details){
                $dr->save();
                $dr->details()->createMany($details->toArray());
            });
            return $dr->only('uuid');
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $dr = DeliveryReceipts::query()
            ->with([
                'details',
                'invoice.client',
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'dr' => $dr,
        ]);
    }

    public function update(DeliveryReceiptsFormRequest $request,$uuid)
    {
        $dr = DeliveryReceipts::query()->findOrFail($uuid);
        $dr->control_no = $request->control_no;
        $dr->invoice_uuid = $request->invoice_uuid;
        $dr->temp_name = $request->temp_name;
        $dr->type = $request->type;
        $dr->date = $request->date;
        $dr->terms = $request->terms;
        $dr->remarks = $request->remarks;

        $details = collect($request->details)->values();
        try {
            DB::transaction(function () use ($dr,$details){
                $dr->save();
                $dr->details()->delete();
                $dr->details()->createMany($details->toArray());
            });
            return $dr->only('uuid');
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function destroy($uuid)
    {
        $dr = DeliveryReceipts::query()->findOrFail($uuid);
        try {
            DB::transaction(function () use ($dr){
                $dr->delete();
                $dr->details()->delete();
            });
            return 1;
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function print($uuid)
    {
        $dr = DeliveryReceipts::query()
            ->with([
                'details',
                'invoice.client'
            ])
            ->findOrFail($uuid);

        return view($this->folder.'print')->with([
            'dr' => $dr,
        ]);
    }
}
