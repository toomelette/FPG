<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\GeneralJournalsFormRequest;
use App\Models\FG\JournalEntriesSubsidiary;
use App\Models\FG\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class GeneralJournalsController extends Controller
{
    public function __construct(
        private $folder = 'fg-accounting.general-journals.',
        private $book = 'GENERAL JOURNAL',
    )
    {
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function store(GeneralJournalsFormRequest $request)
    {
        $journal = new Journals();
        $journal->book = $this->book;
        $journal->uuid = Str::uuid();
        $journal->control_no = $request->control_no;
        $journal->date = $request->date;
        $journal->remarks = $request->remarks;

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
                ->generalJournals();
            return DataTables::of($journals)
                ->addColumn('action',fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->editColumn('control_no',fn($data) => view($this->folder.'dt-control-no')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function edit($uuid)
    {
        $journal = Journals::query()
            ->with(['entries.chartOfAccount'])
            ->generalJournals()
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'journal' => $journal,
        ]);
    }

    public function update(GeneralJournalsFormRequest $request,$uuid)
    {

        $journal = Journals::query()
            ->generalJournals()
            ->findOrFail($uuid);
        $journal->control_no = $request->control_no;
        $journal->date = $request->date;
        $journal->remarks = $request->remarks;

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
            ->generalJournals()
            ->findOrFail($uuid);

        try {
            DB::transaction(function () use ($journal){
                $journal->delete();
                $journal->entries()->delete();
            });
            return 1;
        }catch(\Exception $e){
            abort(503,$e->getMessage());
        }
    }
}
