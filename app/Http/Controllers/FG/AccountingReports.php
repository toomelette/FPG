<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Models\FG\ChartOfAccounts;
use App\Models\FG\Journals;
use App\Models\FG\SubsidiaryAccounts;
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
            ->whereIn('account_code',$accounts->keys()->toArray())
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
    }

    private function analysisOfAccounts(Request $request)
    {
        if(blank($request->date_from)){
            abort(504,'Date from required.');
        }
        if(blank($request->account_code)){
            abort(504,'Account code required.');
        }
        if(blank($request->date_to)){
            $request->date_to = Carbon::now()->format('Y-m-d');
        }

        $balanceForwarded = Journals::query()
            ->select([
                DB::raw('coalesce(sum(debit),0) as debit'),
                DB::raw('coalesce(sum(credit),0) as credit'),
            ])
            ->join('journal_entries','journals.uuid','=','journal_entries.journal_uuid')
            ->where('journal_entries.account_code','=',$request->account_code)
            ->where('date','<',$request->date_from)
            ->first()
        ;
        $journalEntries = Journals::query()
            ->join('journal_entries','journals.uuid','=','journal_entries.journal_uuid')
            ->where('journal_entries.account_code','=',$request->account_code)
            ->whereBetween('journals.date',[$request->date_from,$request->date_to])
            ->orderBy('journals.date')
            ->get()
        ;

        $chartOfAccount = ChartOfAccounts::query()
            ->where('account_code','=',$request->account_code)
            ->firstOrFail();

        return view('fg-accounting.reports.analysis-of-accounts')->with([
            'balanceForwarded' => $balanceForwarded,
            'journalEntries' => $journalEntries,
            'chartOfAccount' => $chartOfAccount,
        ]);
        dd($request->all());
    }

    private function subsidiaryLedger(Request $request)
    {
        if(blank($request->date_to)){
            $request->date_to = Carbon::now()->format('Y-m-d');
        }
        $dateFrom = '1900-01-01';

        if(filled($request->date_from)){
            $dateFrom = $request->date_from;
        }

        $linesBaseQuery = Journals::query()
            ->join('journal_entries','journals.uuid','=','journal_entries.journal_uuid')
            ->join('journal_entries_subsidiaries','journal_entries.uuid','=','journal_entries_subsidiaries.journal_entry_uuid')
            ->orderBy('journals.date')
            ->where('journal_entries_subsidiaries.account_code','=',$request->subsidiary_account_code)
        ;


        $lines =  (clone $linesBaseQuery)
            ->select([
                DB::raw('journals.*'),
                DB::raw('journal_entries_subsidiaries.*')
            ])
            ->where('journals.date','<=',$request->date_to)
            ->where(function ($query) use ($request){
                if(filled($request->date_from)){
                    $query->where('journals.date','>=',$request->date_from);
                }
            })
            ->get()
        ;

        $begBal = ( clone $linesBaseQuery)
            ->where(function ($query) use ($request){
                if(filled($request->date_from)){
                    $query->where('journals.date','<',$request->date_from);
                }else{
                    $query->where('journals.date','<','1990-01-01');
                }
            })
            ->selectRaw('
                COALESCE(SUM(journal_entries_subsidiaries.debit),0) as total_debit,
                COALESCE(SUM(journal_entries_subsidiaries.credit),0) as total_credit
            ')
            ->first();
        ;

        $subsidiaryAccount = SubsidiaryAccounts::query()
            ->where('account_code','=',$request->subsidiary_account_code)
            ->firstOrFail();
        return view('fg-accounting.reports.subsidiary-ledger')->with([
            'lines' => $lines,
            'subsidiaryAccount' => $subsidiaryAccount,
            'begBal' => $begBal
        ]);
        dd($lines);
    }

    private function scheduleOfAccounts(Request $request)
    {
        $dateTo = Carbon::parse($request->date_to);
        $cutoffDate = $dateTo->clone()->firstOfMonth()->subDay()->format('Y-m-d');
        $firstOfSelectedMonth = $dateTo->firstOfMonth()->format('Y-m-d');
        $lastOfSelectedMonth = $dateTo->lastOfMonth()->format('Y-m-d');

        $baseQuery = Journals::query()
            ->select([
                'subsidiary_accounts.account_code',
                'subsidiary_accounts.account_title',
                DB::raw('coalesce(sum(journal_entries_subsidiaries.debit),0) as  debit'),
                DB::raw('coalesce(sum(journal_entries_subsidiaries.credit),0) as  credit')
            ])
            ->join('journal_entries','journals.uuid','=','journal_entries.journal_uuid')
            ->join('journal_entries_subsidiaries','journal_entries.uuid','=','journal_entries_subsidiaries.journal_entry_uuid')
            ->join('subsidiary_accounts','subsidiary_accounts.account_code','=','journal_entries_subsidiaries.account_code')
            ->orderBy('journal_entries_subsidiaries.account_code')
            ->groupBy([
                'journal_entries_subsidiaries.account_code',
                'subsidiary_accounts.account_title'
            ]);
        $accountsOnCutoff = (clone $baseQuery)
            ->where('date','<=',$cutoffDate)
            ->get()
        ;

        $accountsOnSelectedMonth = (clone $baseQuery)
            ->whereBetween('date',[$firstOfSelectedMonth,$lastOfSelectedMonth])
            ->get()
        ;

        $mergedAccountCodes = $accountsOnCutoff
            ->pluck('account_code')
            ->merge($accountsOnSelectedMonth->pluck('account_code'))
            ->unique()
            ->values();

        $usedSubsidiaryAccounts = SubsidiaryAccounts::query()
            ->whereIn('account_code',$mergedAccountCodes->toArray())
            ->orderBy('account_code')
            ->get();
        $chartOfAccount = ChartOfAccounts::query()
            ->where('account_code','=',$request->account_code)
            ->firstOrFail();

        return view('fg-accounting.reports.schedule-of-accounts')->with([
            'usedSubsidiaryAccounts' => $usedSubsidiaryAccounts,
            'accountsOnCutoff' => $accountsOnCutoff,
            'accountsOnSelectedMonth' => $accountsOnSelectedMonth,
            'chartOfAccount' => $chartOfAccount,
        ]);
    }
}