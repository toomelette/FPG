<?php

namespace App\Http\Controllers\FG;

use App\Exports\GenericExport;
use App\Http\Controllers\Controller;
use App\Models\FG\SalesInvoice;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceReportsController extends Controller
{
    public function index()
    {
        return view('fg.invoice-reports.index');
    }

    public function print($report,Request $request)
    {
        $report = Str::of($report)->camel()->toString();

        return $this->$report($request);
    }

    public function salesInvoiceSummary(Request $request)
    {
        $salesInvoices = SalesInvoice::query()
            ->with([
//                'details',
                'client',
            ]);

        if(filled($request->date_from)){
            $salesInvoices = $salesInvoices->where('date','>=',$request->date_from);
        }
        if(filled($request->date_to)){
            $salesInvoices = $salesInvoices->where('date','<=',$request->date_to);
        }
        if(filled($request->ref_book)){
            $salesInvoices = $salesInvoices->where('ref_book','=',$request->ref_book);
        }

        $salesInvoices = $salesInvoices
            ->orderBy('date')
            ->get();

        $params = [
            'salesInvoices' => $salesInvoices,
            'request' => $request,
        ];
        if($request->has('excel') && $request->excel == 'true'){
            return Excel::download(
                new GenericExport(
                    'fg.invoice-reports.sales-invoice-summary-table',
                    $params
                ),
                Helper::makeTitle(__FUNCTION__).'.xlsx'
            );
        }
        return view('fg.invoice-reports.sales-invoice-summary')->with($params);
    }
}
