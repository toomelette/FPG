<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\GeneralJournalsFormRequest;
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

        try {
            DB::transaction(function () use ($journal,$request){
                $journal->save();
                $journal->entries()->createMany(collect($request->entries)->values()->toArray());
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

        try {
            DB::transaction(function () use ($journal,$request){
                $journal->save();
                $journal->entries()->delete();
                $journal->entries()->createMany(collect($request->entries)->values()->toArray());
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
