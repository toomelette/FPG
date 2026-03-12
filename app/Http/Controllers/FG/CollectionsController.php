<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\CollectionFormRequest;
use App\Models\FG\Collections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CollectionsController extends Controller
{
    private $folder;
    public function __construct()
    {
        $this->folder = 'fg.collections.';
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $collections = Collections::query();
            return DataTables::of($collections)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function store(CollectionFormRequest $request)
    {
        $collection = new Collections();
        $collection->uuid = Str::uuid();
        $collection->payment_type = $request->payment_type;
        $collection->ref_no = $request->ref_no;
        $collection->date = $request->date;
        $collection->payor = $request->payor;
        $collection->address = $request->address;
        $collection->remarks = $request->remarks;
        $collection->total_check = $request->total_check;
        $collection->total_cash = $request->total_cash;
        $collection->total_amount = $request->total_amount;
        $collection->cwt = $request->cwt;
        $collection->total_paid = $request->total_paid;
        try {
            DB::transaction(function () use ($collection,$request){
                $collection->save();
                $collection->distributions()->createMany(collect($request->distributions)->values()->toArray());
                $collection->checks()->createMany(collect($request->checks)->values()->toArray());
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $collection = Collections::query()
            ->with([
                'distributions',
                'checks',
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'collection' => $collection,
        ]);
    }

    public function update(CollectionFormRequest $request,$uuid)
    {
        $collection = Collections::query()
            ->findOrFail($uuid);

        $collection->payment_type = $request->payment_type;
        $collection->ref_no = $request->ref_no;
        $collection->date = $request->date;
        $collection->payor = $request->payor;
        $collection->address = $request->address;
        $collection->remarks = $request->remarks;
        $collection->total_check = $request->total_check;
        $collection->total_cash = $request->total_cash;
        $collection->total_amount = $request->total_amount;
        $collection->cwt = $request->cwt;
        $collection->total_paid = $request->total_paid;
        try {
            DB::transaction(function () use ($collection,$request){
                $collection->save();
                $collection->distributions()->delete();
                $collection->checks()->delete();
                $collection->distributions()->createMany(collect($request->distributions)->values()->toArray());
                $collection->checks()->createMany(collect($request->checks)->values()->toArray());
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function destroy($uuid)
    {
        $collection = Collections::query()
            ->findOrFail($uuid);
        try {
            DB::transaction(function () use ($collection){
                $collection->distributions()->delete();
                $collection->checks()->delete();
                $collection->delete();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return 1;
    }
}
