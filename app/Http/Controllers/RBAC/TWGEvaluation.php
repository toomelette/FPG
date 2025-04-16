<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\RBAC\TWGEvaluationFormRequest;
use App\Models\PPUV\Suppliers;
use App\Models\PPUV\Transactions;
use App\Models\RBAC\Evaluation;
use App\Models\RBAC\EvaluationOffers;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TWGEvaluation extends Controller
{
    public function create(Request $request)
    {
        if($request->ajax() && $request->getAq == true){
            $checkExist = Evaluation::query()->where('aq_no','=',$request->aq_no)->first();
            if(!empty($checkExist)){
                return  $checkExist->only('slug');
            }
            $aq = Transactions::query()
                ->with(['details.offers'])
                ->where('ref_book','=','AQ')
                ->where('ref_no','=',$request->aq_no)
                ->first();

            $suppliers = Suppliers::query()
                ->whereIn('slug',$aq->aq->pluck('supplier_slug'))
                ->get();

            $eval = new Evaluation();
            $eval->slug = Str::random();
            $eval->concat_items = $aq->details->pluck('item')->implode('; ');
            $eval->abc = (float) $aq->abc;
            $eval->transaction_slug =  $aq->slug;
            $eval->aq_no =  $aq->ref_no;

            $offersArray = [];
            foreach ($aq->details as $detail){
                foreach ($aq->aq->pluck('supplier_slug') as $supplier_slug) {
                    $amount = (float) $detail->offers->where('aq.supplier_slug',$supplier_slug)->first()->amount;
                    $offersArray[] = [
                        'slug' => Str::random(),
                        'evaluation_slug' => $eval->slug,
                        'supplier' => $suppliers->where('slug',$supplier_slug)->first()->name,
                        'supplier_slug' => $supplier_slug,
                        'item' => $detail->item,
                        'item_slug' => $detail->slug,
                        'qty' => (int) $detail->qty,
                        'offer' => $detail->offers->where('aq.supplier_slug',$supplier_slug)->first()->description,
                        'amount' => $amount == 0 ? null : $amount,
                    ];
                }
            }

            if($eval->save()){
                EvaluationOffers::query()->insert($offersArray);
                return  $eval->only('slug');
            }

            return view('_rbac.twg-evaluation.offers2')->with([
                'aq' => $aq,
            ]);
            dd($offersArray);
            return view('_rbac.twg-evaluation.offers')->with([
                'aq' => $aq,
                'suppliers' => $suppliers,
            ]);
        }

        return view('_rbac.twg-evaluation.create');
    }

    public function edit($slug)
    {
        $eval = Evaluation::query()
            ->with(['offers.relSupplier'])
            ->findOrFail($slug);
        return view('_rbac.twg-evaluation.edit')->with([
                'eval' => $eval,
            ]);
    }

    public function update(TWGEvaluationFormRequest $request,$slug)
    {
        $eval = Evaluation::query()->findOrFail($slug);
        $eval->concat_items = $request->concat_items;
        $eval->abc = Helper::sanitizeAutonum($request->abc);
        $eval->mode_of_procurement = $request->mode_of_procurement;
        $eval->winning_supplier = $request->winning_supplier;
        $eval->bid_price = Helper::sanitizeAutonum($request->bid_price);
        $eval->winning_supplier_slug = $request->winning_supplier_slug;
        $eval->note = $request->note;
        $eval->justification = $request->justification;
        $eval->recommending_approval = $request->recommending_approval;
        $eval->save();
    }

    public function print($slug)
    {
        $eval = Evaluation::query()->findOrFail($slug);
        return view('_rbac.twg-evaluation.print_evaluation')->with([
            'eval' => $eval,
        ]);
    }
}