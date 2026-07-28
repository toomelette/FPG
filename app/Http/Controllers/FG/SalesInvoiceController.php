<?php

namespace App\Http\Controllers\FG;

use App\Exports\GenericExport;
use App\Exports\MultiSheetExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\FG\SalesInvoiceRequest;
use App\Models\FG\ProjectExpenseLiquidation;
use App\Models\FG\ProjectExpenseLiquidationProjects;
use App\Models\FG\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SalesInvoiceController extends Controller
{
    protected $folder;
    public function __construct()
    {
        $this->folder =  'fg.sales-invoice.';
    }

    public function create(Request $request)
    {
        return view($this->folder.'create')->with([
            'book' => 'CASH'
        ]);
    }

    public function store(SalesInvoiceRequest $request)
    {
        $si = new SalesInvoice();
        $si->uuid = Str::uuid();
        $si->ref_book = $request->book;
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
                $si->inventoryLedger()->createMany(collect($request->inventory_ledger)->values()->toArray());
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
                ])
                ->withSum('distributions','amount')
                ->cashInvoices();
            return DataTables::of($salesInvoices)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('invoice_no',fn($data) => view($this->folder.'dt-control-no')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();

        }
        return view($this->folder.'index')->with([
            'book' => 'CASH'
        ]);
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
                $si->inventoryLedger()->delete();
                $si->inventoryLedger()->createMany(collect($request->inventory_ledger)->values()->toArray());
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
                $si->inventoryLedger()->delete();
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
            $expenseLiquidation = ProjectExpenseLiquidation::query()
                ->with([
                    'details'
                ])
                ->whereHas('details',function ($details) use ($uuid){
                    $details->where('sales_invoice_uuid','=',$uuid);
                })
                ->withSum(['details as total_debit' => function ($q) use ($uuid) {
                    $q->where('sales_invoice_uuid', $uuid);
                }], 'debit')
                ->withSum(['details as total_credit' => function ($q) use ($uuid) {
                    $q->where('sales_invoice_uuid', $uuid);
                }], 'credit')
//                ->join('project_expense_liquidations', 'project_expense_liquidations.uuid', '=', 'project_expense_liquidation_projects.project_expense_liquidation_uuid')
            ;

            return DataTables::of($expenseLiquidation)
                ->addColumn('action',function ($data){
                    return view('fg.project-expense-liquidation.dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('details',function ($data){
                    return view('fg.project-expense-liquidation.dt-details')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        if($request->ajax() && $request->has('collectionsTable')){
            $salesInvoice = $salesInvoice->load([
                'distributions.collection.client',
            ]);

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

        if($request->ajax() && $request->has('preparationsTable')){
            $salesInvoice = $salesInvoice->load([
                'preparations' => function ($preparations) {
                    $preparations->withSum('details','amount');
                }
            ]);
            return DataTables::of($salesInvoice->preparations)
                ->addColumn('action',function ($data){

                })
                ->addColumn('details',function ($data){

                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }

        if($request->ajax() && $request->has('deliveriesTable')){
            $salesInvoice = $salesInvoice->load(['deliveries']);
            return DataTables::of($salesInvoice->deliveries)
                ->addColumn('action',function ($data){

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

    public function print($uuid, Request $request)
    {
        if($request->has('summary')){
            return  $this->printSummary($uuid);
        }
        $si = SalesInvoice::query()
            ->with([
                'client',
                'details'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'print-'.strtolower($si->ref_book))->with([
            'salesInvoice' => $si,
        ]);
    }

    public function printSummary($uuid)
    {
        $request = Request::capture();

        $si = SalesInvoice::query()
            ->with([
                'client',
                'details',
                'preparations.details',
                'liquidationDetails.liquidation',
            ])
            ->findOrFail($uuid);

        $liquidationDetails = $si->liquidationDetails->sortBy('date');

        $preparations = $si->preparations->sortBy('date');
        $preparationDetails = $preparations->pluck('details')->flatten();

        if($request->has('excel')){
            $sheets = [
                new GenericExport(
                    $this->folder.'print-table-expenses',
                    [
                        'si' => $si,
                        'liquidationDetails' => $liquidationDetails,
                    ],
                    'Project Expenses'
                ),
                new GenericExport(
                    $this->folder.'print-table-preparations',
                    [
                        'si' => $si,
                        'preparationDetails' => $preparationDetails,
                    ],
                    'Project Preparations'
                ),
            ];
            return Excel::download(new MultiSheetExport($sheets),'Summary '.$si->invoice_no.' - '.$si->remarks.'.xlsx');
        }


        return view($this->folder.'print-summary')->with([
            'si' => $si,
            'preparationDetails' => $preparationDetails,
            'liquidationDetails' => $liquidationDetails,
        ]);
    }
}