<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\PayrollAdjustmentFormRequest;
use App\Models\FG\PayrollAdjustments;
use App\Models\FG\PayrollEmployeeAdjustments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PayrollAdjustmentsController extends Controller
{
    public function __construct(
        private $folder = 'fg.payroll-adjustments.',
    )
    {
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $adjustments = PayrollAdjustments::query();
            return DataTables::of($adjustments)
                ->addColumn('action',fn($data) => view($this->folder.'dt-actions')->with(['adjustment' => $data]))
                ->escapeColumns([])
                ->setRowId('id')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function store(PayrollAdjustmentFormRequest $request)
    {
        $adjustment = new PayrollAdjustments();
        $adjustment->code = $request->code;
        $adjustment->description = $request->description;
        $adjustment->type = $request->type;
        $adjustment->priority = $request->priority;

        try {
            DB::transaction(function () use ($adjustment){
                $adjustment->save();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $adjustment->only('id');
    }

    public function edit($id)
    {
        $adjustment = PayrollAdjustments::query()->findOrFail($id);
        return view($this->folder.'edit')->with([
            'adjustment' => $adjustment,
        ]);
    }
    public function update(PayrollAdjustmentFormRequest $request,$id)
    {
        $adjustment = PayrollAdjustments::query()->findOrFail($id);
        $adjustment->description = $request->description;
        $adjustment->type = $request->type;
        $adjustment->priority = $request->priority;

        try {
            DB::transaction(function () use ($adjustment){
                $adjustment->save();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $adjustment->only('id');
    }
}
