<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\CashDisbursementsFormRequest;
use App\Models\FG\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CashDisbursementsController extends Controller
{
    public function __construct(
        private $folder = 'fg-accounting.cash-disbursements.',
        private $book = 'CASH DISBURSEMENT',
    )
    {
    }

    public function create()
    {
        return view($this->folder.'create');
    }

    public function store(CashDisbursementsFormRequest $request)
    {
        $journal = new Journals();
        $journal->book = $this->book;
        $journal->uuid = Str::uuid();
        $journal->control_no = $request->control_no;
        $journal->date = $request->date;
        $journal->counterparty = $request->counterparty;
        $journal->remarks = $request->remarks;
        $journal->bank = $request->bank;
        $journal->check_no = $request->check_no;
        $journal->check_amount = $request->check_amount;

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
                ->cashDisbursements();
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
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'journal' => $journal,
        ]);
    }

    public function update(CashDisbursementsFormRequest $request,$uuid)
    {

        $journal = Journals::query()
            ->findOrFail($uuid);
        $journal->control_no = $request->control_no;
        $journal->date = $request->date;
        $journal->counterparty = $request->counterparty;
        $journal->remarks = $request->remarks;
        $journal->bank = $request->bank;
        $journal->check_no = $request->check_no;
        $journal->check_amount = $request->check_amount;

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
