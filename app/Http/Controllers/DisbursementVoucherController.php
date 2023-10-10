<?php

namespace App\Http\Controllers;

use App\Models\DisbursementVoucher;
use App\Models\DisbursementVoucherDetails;
use App\Swep\Helpers\__sanitize;
use App\Swep\Helpers\Helper;
use App\Swep\Repositories\DisbursementVoucherRepository;
use App\Swep\Services\DisbursementVoucherService;
use App\Http\Requests\DisbursementVoucher\DisbursementVoucherFormRequest;
use App\Http\Requests\DisbursementVoucher\DisbursementVoucherSetNoRequest;
use App\Http\Requests\DisbursementVoucher\DisbursementVoucherFilterRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class DisbursementVoucherController extends Controller{


    protected $disbursement_voucher;


    public function __construct(DisbursementVoucherService $disbursement_voucher){

        $this->disbursement_voucher = $disbursement_voucher;

    }


    
    public function index(Request $request, $filter_user_only = null){
        return view('dashboard.accounting.moved');
        if($request->ajax() && $request->has('draw')){

            return $this->fetchTbl($request);
        }
        return view('dashboard.disbursement_voucher.index');
        return $this->disbursement_voucher->fetch($request);

    }

    public function fetchTbl($request,$user_only = null){
        $dvs = DisbursementVoucher::query();

        if($user_only == 1){
            $dvs = $dvs->where('user_created','=',Auth::user()->user_id);
        }
        if($request->has('department_name') && $request->department_name != null){
            $dvs = $dvs->where('department_name','=',$request->department_name);
        }
        if($request->has('department_unit_name') && $request->department_unit_name != null){
            $dvs = $dvs->where('department_unit_name','=',$request->department_unit_name);
        }
        if($request->has('project_code') && $request->project_code != null){
            $dvs = $dvs->where('project_code','=',$request->project_code);
        }
        if($request->has('fund_source_id') && $request->fund_source_id != null){
            $dvs = $dvs->where('fund_source_id','=',$request->fund_source_id);
        }

        if($request->has('project_id') && $request->project_id != null){
            $dvs = $dvs->where('project_id','=',$request->project_id);
        }

        if($request->has('filter_date') && $request->filter_date == 'on'){
            if($request->has('date_range') && $request->date_range != null){
                $date_range = __sanitize::date_range($request->date_range);
                $dv = $dvs->whereBetween('date',$date_range);
            }
        }

        return DataTables::of($dvs)
            ->addColumn('action',function ($data){
                $destroy_route = "'".route("dashboard.disbursement_voucher.destroy","slug")."'";
                $slug = "'".$data->slug."'";
                $del_btn = '<li>
                                <a href="#" data="'.$data->slug.'" onclick="delete_data('.$slug.','.$destroy_route.')" class=" delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
                                    <span class="text-danger"><i class="fa fa-trash"></i> Delete </span>
                                </a>
                            </li>';
                if($data->user_created != Auth::user()->user_id){
                    $del_btn = '';
                }
                $button = '<div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm show_dv_btn" data="'.$data->slug.'" data-toggle="modal" data-target ="#show_dv_modal" title="View more" data-placement="left">
                                        <i class="fa fa-file-text"></i>
                                    </button>
                                   <button type="button" class="btn btn-default btn-sm print_dv_btn" data="'.$data->slug.'" data-toggle="modal" data-target ="#print_dv_modal" title="Print" data-placement="left">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm edit_dv_btn" data="'.$data->slug.'" data-toggle="modal" data-target ="#edit_dv_modal" title="Edit" data-placement="left">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li>
                                            <a data="'.$data->slug.'" href="#"  class="save_as_btn" data-toggle="modal" data-target="#save_as_modal"> 
                                                <span><i class="fa fa-plus"></i> Save as new </span>
                                            </a>
                                        </li>
                                           '.$del_btn.'
                                      </ul>
                                    </div>
                                </div>';
                return $button;
            })
            ->editColumn('explanation',function ($data){
                return Str::limit(strip_tags($data->explanation),80,'...');
            })
            ->editColumn('date',function ($data){
                return Carbon::parse($data->date)->format('M. d, Y');
            })
            ->editColumn('amount',function ($data){
                return number_format($data->amount,2);
            })
            ->editColumn('dv_no',function ($data){
                if($data->dv_no == null){
                    return '<a href="#" id="dv_set_no_link" class="text-red no_dv_set" placeholder="" data="'.$data->slug.'" style="text-decoration:underline;">
                            <b>Not Set!</b>
                          </a>';
                }else{
                    return '<a href="#" id="dv_set_no_link" class="no_dv_set" placeholder="'.$data->dv_no.'"  data="'.$data->slug.'"  style="text-decoration:underline;">
                            <b>'.$data->dv_no.'</b>
                          </a>';
                }
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }



    public function userIndex(DisbursementVoucherFilterRequest $request){
        return view('dashboard.accounting.moved');
        if($request->ajax() && $request->has('draw')){
            return $this->fetchTbl($request,$user_only = 1);
        }
        return view('dashboard.disbursement_voucher.index');

    }



    public function create(){
        return view('dashboard.accounting.moved');
        return view('dashboard.disbursement_voucher.create');
        
    }

    public function printPreview($slug){
        $dv = $this->findBySlug($slug);
        return view('dashboard.disbursement_voucher.print_preview')->with([
            'dv' => $dv,
        ]);
        return $slug;
    }

   
    public function store(DisbursementVoucherFormRequest $request, DisbursementVoucherRepository $disbursementVoucherRepository){

        $dv = new DisbursementVoucher;
        $dv->slug = Str::random(32);
        $dv->dv_id = $disbursementVoucherRepository->getDvIdInc();
        $dv->user_id = Auth::user()->user_id;
        $dv->doc_no = 'DV' . rand(10000000, 99999999);
        $dv->date = Carbon::now()->format('Y-m-d');
        $dv->project_id = $request->project_id;
        $dv->fund_source = $request->fund_source;
        $dv->mode_of_payment = $request->mode_of_payment;
        $dv->payee = $request->payee;
        $dv->address =  $request->address;
        $dv->tin = $request->tin;
        $dv->bur_no = $request->bur_no;
        $dv->department_name = $request->department_name;
        $dv->department_unit_name = $request->department_unit_name;
        $dv->project_code = $request->project_code;
        $dv->explanation = $request->explanation;
        $dv->certified_supervisor = $request->certified_supervisor;
        $dv->certified_supervisor_position =  $request->certified_supervisor_position;
        $dv->certified_by = $request->certified_by;
        $dv->certified_by_position =  $request->certified_by_position;
        $dv->approved_by = $request->approved_by;
        $dv->approved_by_position = $request->approved_by_position;
        $dv->created_at = Carbon::now();
        $dv->updated_at = Carbon::now();
        $dv->ip_created = request()->ip();
        $dv->ip_updated = request()->ip();
        $dv->user_created = Auth::user()->user_id;
        $dv->user_updated = Auth::user()->user_id;
        if($dv->mode_of_payment == 'OTHERS'){
            $dv->mode_of_payment_specify = $request->mode_of_payment_specify;
        }else{
            $dv->mode_of_payment_specify = '';
        }
        $arr = [];
        $sum_of_amount = 0;
        foreach ($request->amount as $key => $value){
            $sum_of_amount = $sum_of_amount+Helper::sanitizeAutonum($value);
            array_push($arr,[
                'slug' => Str::random(16),
                'dv_slug' => $dv->slug,
                'dv_id' => $dv->dv_id,
                'amount' => Helper::sanitizeAutonum($value),
                'resp_center' => $request->resp_center[$key],
                'mfo_pap' => $request->mfo_pap[$key],
            ]);
        }
        $dv->amount = $sum_of_amount;
        DisbursementVoucherDetails::insert($arr);
        $dv->save();

        if($dv){
            return $dv->only('slug');
        }
        abort(503,'Error saving data.');
    }


    
    public function show($slug){
        $dv = $this->findBySlug($slug);
        return view('dashboard.disbursement_voucher.show')->with([
            'dv' => $dv,
        ]);
        return $this->disbursement_voucher->show($slug);
    }

    private function findBySlug($slug){
        $dv = DisbursementVoucher::query()->where('slug','=',$slug)->first();
        if(empty($dv)){
            abort(404);
        }
        return $dv;
    }


    
    public function edit($slug){
        $dv = $this->findBySlug($slug);
        return view('dashboard.disbursement_voucher.edit')->with([
            'dv' => $dv,
            'type' => 'Edit',
        ]);
        return $this->disbursement_voucher->edit($slug);
        
    }



    public function update(DisbursementVoucherFormRequest $request, $slug){
        $dv = $this->findBySlug($slug);
//        $dv->doc_no = 'DV' . rand(10000000, 99999999);
        $dv->project_id = $request->project_id;
        $dv->fund_source = $request->fund_source;
        $dv->mode_of_payment = $request->mode_of_payment;
        $dv->payee = $request->payee;
        $dv->address =  $request->address;
        $dv->tin = $request->tin;
        $dv->bur_no = $request->bur_no;
        $dv->explanation = $request->explanation;
        $dv->certified_supervisor = $request->certified_supervisor;
        $dv->certified_supervisor_position =  $request->certified_supervisor_position;
        $dv->certified_by = $request->certified_by;
        $dv->certified_by_position =  $request->certified_by_position;
        $dv->approved_by = $request->approved_by;
        $dv->approved_by_position = $request->approved_by_position;
        $dv->updated_at = Carbon::now();
        $dv->ip_updated = request()->ip();
        $dv->user_updated = Auth::user()->user_id;
        if($dv->mode_of_payment == 'OTHERS'){
            $dv->mode_of_payment_specify = $request->mode_of_payment_specify;
        }else{
            $dv->mode_of_payment_specify = '';
        }
        $arr = [];
        $sum_of_amount = 0;

        foreach ($request->amount as $key => $value){
            $sum_of_amount = $sum_of_amount+Helper::sanitizeAutonum($value);
            array_push($arr,[
                'slug' => Str::random(16),
                'dv_slug' => $dv->slug,
                'dv_id' => $dv->dv_id,
                'amount' => Helper::sanitizeAutonum($value),
                'resp_center' => $request->resp_center[$key],
                'mfo_pap' => $request->mfo_pap[$key],
            ]);
        }
        $dv->amount = $sum_of_amount;
        $dv->details()->delete();
        DisbursementVoucherDetails::insert($arr);
        $dv->save();
        if($dv){
            return $dv->only('slug');
        }
        abort(503,'Error saving data.');
    }


    
    public function destroy($slug){

        $dv = $this->disbursement_voucher->destroy($slug);
        if($dv){
            if($dv->user_created != Auth::user()->user_id){
                abort(503,'Not enough privileges to delete this voucher');
            }
            return 1;
        }
        abort(503,'Error deleting data.');
    }



    public function print($slug, $type){

        return $this->disbursement_voucher->print($slug, $type);
        
    }

        

    public function setNo(DisbursementVoucherSetNoRequest $request, $slug){
        $dv = $this->disbursement_voucher->setNo($request, $slug);
        if($dv){
            return $dv->only('slug');
        }
        abort(503,'Error saving data.');
    }



    public function confirmCheck($slug){

        return $this->disbursement_voucher->confirmCheck($slug);
        
    }




    public function saveAs($slug){
        $dv = $this->findBySlug($slug);
        return view('dashboard.disbursement_voucher.edit')->with([
            'dv' => $dv,
            'type' => 'Save as',
        ]);

        return $this->disbursement_voucher->saveAs($slug);
        
    }

    

    
}
