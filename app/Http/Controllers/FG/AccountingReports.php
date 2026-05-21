<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Models\FG\ChartOfAccounts;
use App\Models\FG\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    private function trialBalance(Request $request)
    {
        $lastOfMonth = Carbon::parse($request->month_to)->lastOfMonth()->format('Y-m-d');
        $accounts = Journals::query()
            ->select([
                'journal_entries.account_code',
                DB::raw('COALESCE(SUM(debit), 0) AS debit'),
                DB::raw('COALESCE(SUM(credit), 0) AS credit'),
                DB::raw('COALESCE(SUM(debit), 0) - COALESCE(SUM(credit), 0) AS balance')
            ])
            ->join('journal_entries','journals.uuid','=','journal_entries.journal_uuid')
            ->where('journals.date','<=',$lastOfMonth)
            ->groupBy('journal_entries.account_code')
            ->get()
            ->keyBy('account_code')
        ;

        $chartOfAccounts = ChartOfAccounts::query()
            ->orderBy('account_code')
            ->get()
            ->map(function ($coa) use($accounts){
                $account = $accounts->get($coa->account_code);

                $coa->debit = 0;
                $coa->credit = 0;
                $coaBalance = ($account->debit ?? null) - ($account->credit ?? null);
                if($coaBalance < 0){
                    $coa->credit = $coaBalance * -1;
                }elseif($coaBalance > 0){
                    $coa->debit = $coaBalance;
                }else{
                    $coa->balance_type = null;
                }
                $coa->balance = $coa->debit - $coa->credit;
                return $coa;
            })
        ;

        return view('fg-accounting.reports.trial-balance')->with([
            'chartOfAccounts' => $chartOfAccounts,
        ]);
        dd($chartOfAccounts);
    }
}