<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\HRU\COS;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class COSController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax() && $request->has('draw')){
            $cos = COS::query()
                ->with(['employees']);
            return DataTables::of($cos)
                ->addColumn('actions',function ($data){
                    return view('_hru.cos.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('total_cos',function ($data){
                    return view('_hru.cos.dtTotalCos')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('date_from',function ($data){
                    return view('_hru.cos.dtDateFrom')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('memo_code',function ($data){
                    return view('_hru.cos.dtMemoCode')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('funds_available',function ($data){
                    return view('_hru.cos.dtFundsAvailable')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('funds_available',function ($data){
                    return view('_hru.cos.dtFundsAvailable')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('is_active',function ($data){
                    return view('_hru.cos.dtIsActive')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns()
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.cos.index');
    }

    public function store(Request $request)
    {
        $cos = new COS();
        $cos->slug = Str::random();
        $cos->date_from = $request->date_from;
        $cos->date_to = $request->date_to;
        $cos->memo_date = $request->memo_date;
        $cos->memo_code = $request->memo_code;
        $cos->funds_available = $request->funds_available;
        $cos->funds_available_position = $request->funds_available_position;
        if ($cos->save()){
            return $cos->only('slug');
        }
        abort(503,'Error saving contract of service');
    }

    public function edit($slug)
    {
        $cos = COS::query()->findOrFail($slug);
        return view('_hru.cos.edit',compact('cos'));
    }

    public function update(Request $request,$slug)
    {
        if($request->has('activeInactive')){
            return $this->activeInactive($request,$slug);
        }
        $cos = COS::query()->findOrFail($slug);
        $cos->date_from = $request->date_from;
        $cos->date_to = $request->date_to;
        $cos->memo_date = $request->memo_date;
        $cos->memo_code = $request->memo_code;
        $cos->funds_available = $request->funds_available;
        $cos->funds_available_position = $request->funds_available_position;
        if ($cos->save()){
            return $cos->only('slug');
        }
        abort(503,'Error saving contract of service');
    }

    public function activeInactive(Request $request,$slug)
    {
        $cos = COS::query()->findOrFail($slug);
        $isActive = filter_var($request->checked,258);
        if($isActive){
            $cos->is_active = 1;
        }else{
            $cos->is_active = null;
        }
        if($cos->update()){
            return $cos->only('slug');
        }
        abort(503,'Error updating contract of service');

    }

    public function destroy($slug)
    {
        $cos = COS::query()->findOrFail($slug);
        $cos->employees()->delete();
        if($cos->delete()){
            return 1;
        }
        abort(503,'Error deleting contract of service');
    }
}