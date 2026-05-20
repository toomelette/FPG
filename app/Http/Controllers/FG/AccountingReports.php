<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Models\FG\ChartOfAccounts;
use App\Models\FG\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AccountingReports extends Controller
{
    public function index()
    {
        return view('fg-accounting.reports.index');
    }

    public function print($report,Request $request)
    {
        $report = Str::of($report)->camel()->toString();

        return $this->$report($request);
    }

    private function journalRegister(Request $request)
    {
        $journals = Journals::query()
            ->with(['entries.chartOfAccount']);
        if($request->book == 'CASH RECEIPT'){
            $journals = $journals->cashReceipts();
        }
        if($request->book == 'CASH DISBURSEMENT'){
            $journals = $journals->cashDisbursements();
        }
        if($request->book == 'GENERAL JOURNAL'){
            $journals = $journals->generalJournals();
        }

        if(filled($request->date_from)){
            $journals = $journals->where('date','>=',$request->date_from);
        }
        if(filled($request->date_to)){
            $journals = $journals->where('date','<=',$request->date_to);
        }

        $journals = $journals
            ->orderBy('date')
            ->get();

        return view('fg-accounting.reports.journal-register')->with([
            'request' => $request,
            'journals' => $journals,
        ]);
    }

    private function generalLedger(Request $request)
    {
        $journals = Journals::query()
            ->with([
                'entries' => function ($entries) use($request) {
                    $entries->where('account_code','=',$request->account_code);
                }
            ])
        ;

        if(filled($request->month_from)){

            $journals = $journals->where('date','>=',Carbon::parse($request->month_from)->firstOfMonth()->format('Y-m-d'));
        }
        if(filled($request->month_to)){
            $journals = $journals->where('date','<=',Carbon::parse($request->month_to)->lastOfMonth()->format('Y-m-d'));
        }

        $journals = $journals->get();

        $chartOfAccount = ChartOfAccounts::query()
            ->where('account_code','=',$request->account_code)
            ->firstOrFail();

        $journalEntries = $journals->pluck('entries')
            ->flatten()
            ->sortBy(function ($entry){
                return [
                    $entry->journal->book,
                    Carbon::parse($entry->journal->date),
                ];
            })
            ->groupBy([
                function ($entry) {
                    return Carbon::parse($entry->journal->date)->lastOfMonth()->format('Y-m-d');
                },
                function ($entry) {
                    return $entry->journal->book;
                },
            ])
        ;
        return view('fg-accounting.reports.general-ledger')->with([
            'months' => $journalEntries,
            'chartOfAccount' => $chartOfAccount,
        ]);
    }
}