<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\SalesInvoiceRequest;
use App\Models\FG\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SalesInvoiceController extends Controller
{
    protected $folder;
    public function __construct()
    {
        $this->folder =  'fg.sales-invoice.';
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function store(SalesInvoiceRequest $request)
    {
        $si = new SalesInvoice();
        $si->uuid = Str::uuid();
        $si->invoice_no = $request->invoice_no;
        $si->date = $request->date;
        $si->client_uuid = $request->client_uuid;
        $si->terms = $request->terms;
        $si->remarks = $request->remarks;
        $si->tax_base = $request->tax_base;
        $si->vat = $request->vat;
        $si->total_amount_due = $request->total_amount_due;
        try {
            DB::transaction(function () use ($request, $si){
                $si->save();
                $si->details()->createMany(collect($request->details)->values()->toArray());
            });
            return $si->only('uuid');
        }catch (\Exception $e){
            abort(503, $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $salesInvoices = SalesInvoice::query()
                ->with([
                    'client',
                    'details',
                ]);
            return DataTables::of($salesInvoices)
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

    public function edit($uuid)
    {
        $si = SalesInvoice::query()
            ->with([
                'client',
                'details'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'salesInvoice' => $si,
        ]);
    }

    public function update(SalesInvoiceRequest $request,$uuid)
    {
        $si = SalesInvoice::query()
            ->findOrFail($uuid);
        $si->invoice_no = $request->invoice_no;
        $si->date = $request->date;
        $si->client_uuid = $request->client_uuid;
        $si->terms = $request->terms;
        $si->remarks = $request->remarks;
        $si->tax_base = $request->tax_base;
        $si->vat = $request->vat;
        $si->total_amount_due = $request->total_amount_due;

        try {
            DB::transaction(function () use ($request, $si){
                $si->save();
                $si->details()->delete();
                $si->details()->createMany(collect($request->details)->values()->toArray());
            });
            return $si->only('uuid');
        }catch (\Exception $e){
            abort(503, $e->getMessage());
        }
    }

    public function destroy($uuid)
    {
        $si = SalesInvoice::query()
            ->findOrFail($uuid);
        try {
            DB::transaction(function ($q) use ($si){
                $si->delete();
                $si->details()->delete();
            });
            return 1;
        }catch (\Exception $e){
            abort(503);
        }
    }
    public function show($uuid,Request $request)
    {
        $salesInvoice = SalesInvoice::query()
            ->with([
                'client'
            ])
            ->findOrFail($uuid);

        if($request->ajax() && $request->has('liquidationsTable')){
            $salesInvoice = $salesInvoice->load(['liquidations']);
            return DataTables::of($salesInvoice->liquidations)
                ->addColumn('action',function ($data){
                    return view('fg.project-expense-liquidation.dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('details',function ($data){

                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        if($request->ajax() && $request->has('collectionsTable')){
            $salesInvoice = $salesInvoice->load(['distributions.collection']);
            return DataTables::of($salesInvoice->distributions)
                ->addColumn('action',function ($data){
//                    return view('fg.collections.dt-actions')->with([
//                        'data' => $data,
//                    ]);
                })
                ->addColumn('details',function ($data){

                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'show')->with([
            'salesInvoice' => $salesInvoice,
        ]);
    }
}