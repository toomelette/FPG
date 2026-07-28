<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Models\FG\SalesInvoice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ChargeSalesInvoiceController extends Controller
{
    public function __construct()
    {
        $this->folder =  'fg.sales-invoice.';
    }

    public function create(Request $request)
    {
        return view($this->folder.'create')->with([
            'book' => 'CHARGE'
        ]);
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $salesInvoices = SalesInvoice::query()
                ->with([
                    'client',
                    'details',
                ])
                ->chargeInvoices();
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
            'book' => 'CHARGE'
        ]);
    }
}
