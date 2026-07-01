<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\StocksFormRequest;
use App\Models\FG\InventoryTransfers;
use App\Models\FG\ProjectPreparations;
use App\Models\FG\ReceivingReports;
use App\Models\FG\SalesInvoice;
use App\Models\FG\Stocks;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class StocksController extends Controller
{
    public function __construct(

        public StockService $stockService,
    )
    {
        $this->folder = 'fg.stocks.';
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
//            $stocks = Stocks::query();
            $union = $this->stockService->getUnionOfStockMovements(null);

            $balances = DB::query()
                ->fromSub($union, 't')
                        ->selectRaw("
                    stock_uuid,
                    SUM(qty * direction) as ending_balance
                ")
                ->groupBy('stock_uuid');


            $stocks = DB::table('stocks')
                ->leftJoinSub($balances, 'b', function ($join) {
                    $join->on('stocks.uuid', '=', 'b.stock_uuid');
                })
                ->select([
                    'stocks.*',
                    DB::raw('COALESCE(b.ending_balance, 0) as ending_balance')
                ]);
            return DataTables::of($stocks)
                ->addColumn('action', fn($data) => view($this->folder.'dt-action')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function store(StocksFormRequest $request)
    {
        $stock = new Stocks();
        $stock->uuid = Str::uuid();
        $stock->name = $request->name;
        $stock->description = $request->description;
        $stock->uom = $request->uom;
        $stock->category = $request->category;
        $stock->bar_code = $request->bar_code;
        $stock->beg_bal_date = $request->beg_bal_date;
        $stock->beg_bal_qty = $request->beg_bal_qty;

        try {
            DB::transaction(function () use ($stock){
                $stock->save();
            });
        }catch (\Exception $exception){
            abort(503, $exception->getMessage());
        }
        return $stock->only('uuid');
    }

    public function edit($uuid)
    {
        $stock = Stocks::query()->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'stock' => $stock,
        ]);
    }

    public function update(StocksFormRequest $request,$uuid)
    {
        $stock = Stocks::query()->findOrFail($uuid);
        $stock->name = $request->name;
        $stock->description = $request->description;
        $stock->uom = $request->uom;
        $stock->category = $request->category;
        $stock->bar_code = $request->bar_code;
        $stock->beg_bal_date = $request->beg_bal_date;
        $stock->beg_bal_qty = $request->beg_bal_qty;

        try {
            DB::transaction(function () use ($stock){
                $stock->save();
            });
        }catch (\Exception $exception){
            abort(503, $exception->getMessage());
        }
        return $stock->only('uuid');
    }

    public function show($uuid)
    {
        $stock = Stocks::query()->findOrFail($uuid);

        $union = $this->stockService->getUnionOfStockMovements($stock);

        $ledger = DB::query()
            ->fromSub($union,'t')
            ->selectRaw("
                t.*,
                qty * direction as movement
            ")
            ->where('stock_uuid','=',$stock->uuid)
            ->orderBy('date')
            ->get();


        return view($this->folder.'show')->with([
            'stock' => $stock,
            'ledger' => $ledger,
        ]);
    }
}
