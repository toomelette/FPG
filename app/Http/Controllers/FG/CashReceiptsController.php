<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\CashReceiptsFormRequest;
use App\Models\FG\JournalEntriesSubsidiary;
use App\Models\FG\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CashReceiptsController extends Controller
{
    public function __construct(
        private $folder = 'fg-accounting.cash-receipts.',
        private $book = 'CASH RECEIPT',
    )
    {
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function store(CashReceiptsFormRequest $request)
    {
        $journal = new Journals();
        $journal->book = $this->book;
        $journal->uuid = Str::uuid();
        $journal->control_no = $request->control_no;
        $journal->date = $request->date;
        $journal->counterparty = $request->counterparty;
        $journal->client_uuid = $request->client_uuid;
        $journal->collection_uuid = $request->collection_uuid;
        $journal->remarks = $request->remarks;
        $journal->bank = $request->bank;
        $journal->check_no = $request->check_no;
        $journal->check_amount = $request->check_amount;
        $journal->cash_amount = $request->cash_amount;

        $journalEntries = [];
        $subsidiaries = [];
        foreach ($request->entries as $rowId => $entry){
            $entryUuid = Str::uuid();
            $journalEntries[] = [
                "uuid" => $entryUuid,
                "account_code" => $entry['account_code'],
                "debit" => $entry['debit'],
                "credit" => $entry['credit'],
            ];
            $journalSubsidiaries = $request->subsidiary_ledgers[$rowId] ?? [];
            foreach ($journalSubsidiaries as $journalSubsidiary){
                $subsidiaries[] = [
                    "journal_entry_uuid" => $entryUuid,
                    "account_code" => $journalSubsidiary->account_code,
                    "debit" => $journalSubsidiary->debit == 0 ? null : $journalSubsidiary->debit,
                    "credit" => $journalSubsidiary->credit == 0 ? null : $journalSubsidiary->credit,
                ];
            }
        }


        try {
            DB::transaction(function () use ($journal,$journalEntries,$subsidiaries){
                $journal->save();
                $journal->entries()->createMany($journalEntries);
                JournalEntriesSubsidiary::query()->insert($subsidiaries);
            });
            return $journal->only('uuid');
        }catch(\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $journals = Journals::query()
                ->cashReceipts();
            return DataTables::of($journals)
                ->addColumn('action',fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function edit($uuid)
    {
        $journal = Journals::query()
            ->with([
                'entries.chartOfAccount',
                'collection'
            ])
            ->cashReceipts()
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'journal' => $journal,
        ]);
    }

    public function update(CashReceiptsFormRequest $request,$uuid)
    {

        $journal = Journals::query()
            ->cashReceipts()
            ->findOrFail($uuid);
        $journal->control_no = $request->control_no;
        $journal->date = $request->date;
        $journal->counterparty = $request->counterparty;
        $journal->remarks = $request->remarks;
        $journal->bank = $request->bank;
        $journal->check_no = $request->check_no;
        $journal->check_amount = $request->check_amount;
        $journal->cash_amount = $request->cash_amount;
        $journal->client_uuid = $request->client_uuid;
        $journal->collection_uuid = $request->collection_uuid;

        $journalEntries = [];
        $subsidiaries = [];
        foreach ($request->entries as $rowId => $entry){
            $entryUuid = Str::uuid();
            $journalEntries[] = [
                "uuid" => $entryUuid,
                "account_code" => $entry['account_code'],
                "debit" => $entry['debit'],
                "credit" => $entry['credit'],
            ];
            $journalSubsidiaries = $request->subsidiary_ledgers[$rowId] ?? [];
            foreach ($journalSubsidiaries as $journalSubsidiary){
                $subsidiaries[] = [
                    "journal_entry_uuid" => $entryUuid,
                    "account_code" => $journalSubsidiary->account_code,
                    "debit" => $journalSubsidiary->debit == 0 ? null : $journalSubsidiary->debit,
                    "credit" => $journalSubsidiary->credit == 0 ? null : $journalSubsidiary->credit,
                ];
            }
        }


        try {
            DB::transaction(function () use ($journal,$journalEntries,$subsidiaries){
                $journal->entriesSubsidiaries()->delete();
                $journal->entries()->delete();
                $journal->save();
                $journal->entries()->createMany($journalEntries);
                JournalEntriesSubsidiary::query()->insert($subsidiaries);
            });
            return $journal->only('uuid');
        }catch(\Exception $e){
            abort(503,$e->getMessage());
        }
    }
    public function destroy($uuid)
    {
        $journal = Journals::query()
            ->cashReceipts()
            ->findOrFail($uuid);

        try {
            DB::transaction(function () use ($journal){
                $journal->entriesSubsidiaries()->delete();
                $journal->entries()->delete();
                $journal->delete();
            });
            return 1;
        }catch(\Exception $e){
            abort(503,$e->getMessage());
        }
    }
}
