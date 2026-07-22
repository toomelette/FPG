<?php


namespace App\Http\Controllers;


use App\Models\Applicant;
use App\Models\ApplicantPositionApplied;
use App\Models\Budget\ChartOfAccounts;
use App\Models\Course;
use App\Models\Document;
use App\Models\Employee;
use App\Models\FG\Clients;
use App\Models\FG\CollectionChecks;
use App\Models\FG\Collections;
use App\Models\FG\Journals;
use App\Models\FG\ProjectExpenseLiquidation;
use App\Models\FG\ProjectExpenseLiquidationDetails;
use App\Models\FG\Projects;
use App\Models\FG\SalesInvoice;
use App\Models\FG\Stocks;
use App\Models\HRPayPlanitilla;
use App\Models\PPU\Pap;
use App\Models\SSL;
use App\Swep\Helpers\Helper;
use App\Swep\Services\Budget\ORSService;
use App\Swep\Services\Budget\PapService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AjaxController extends Controller
{

    protected $papService;
    protected $orsService;
    public function __construct(PapService $papService, ORSService $orsService)
    {
        $this->papService = $papService;
        $this->orsService = $orsService;
    }

    public function get($for, ORSService $ORSService, Request $r){

        //FG
        if($for == 'clients'){
            return $this->clients($r);
        }
        if($for == 'projects-grouped-by-clients'){
            return $this->projectsGroupedByClients($r);
        }
        if($for == 'project-expense-liquidation-description'){
            return $this->projectExpenseLiquadationDescription($r);
        }
        if($for == 'stocks'){
            return $this->stocks($r);
        }

        if($for == 'invoices-grouped-by-clients'){
            return $this->invoicesGroupedByClients($r);
        }

        if($for == 'or_nos'){
            return $this->orNos($r);
        }

        if($for == 'banks'){
            return $this->banks($r);
        }

        if($for == 'account-codes'){
            return $this->accountCodes($r);
        }
        if($for == 'subsidiary-account-codes'){
            return $this->subsidiaryAccountCodes($r);
        }

        if($for == 'payor'){
            return $this->payor($r);
        }

        if($for == 'counterparty-info'){
            return $this->counterpartyInfo($r);
        }

        if($for == 'new-journal-no'){
            return $this->getNewJournalNo($r);
        }




        if($for == 'compute_monthly_salary'){
            return $this->compute_monthly_salary();
        }
        if($for == 'educational_background'){
            return view('ajax.employee.add_school');
        }

        if($for == 'eligibility'){
            return view('ajax.employee.add_eligibility');
        }

        if($for == 'work_experience'){
            $rand = Str::random(16);
            return [
                'view' => view('ajax.employee.add_work_experience')->with([
                                'rand' => $rand,
                            ])->render(),
                'rand' => $rand,
            ];
        }

        if($for == 'close_bulletin'){
            return $this->close_bulletin();
        }

        if($for == 'document_person_to'){
            return $this->document_person_to($r);
        }
        if($for == 'document_person_from'){
            return $this->document_person_from($r);
        }
        if($for == 'dv_add_item'){
            return $this->dv_add_item();
        }

        if($for == 'position_applied'){
            return $this->position_applied();
        }

        if($for == 'applicant_courses'){
            return $this->applicant_courses();
        }
        if($for == 'search_active_employees'){
            return $this->search_active_employees();
        }

        if($for == 'applicant_filter_position'){
            return $this->applicant_filter_position();
        }

        if($for == 'applicant_filter_item_no'){
            return $this->applicant_filter_item_no();
        }

        if($for == 'new-user-from-employee'){
            return $this->newUserFromEmployee($r);
        }



        if($for == 'new-employee-for-cos'){
            return $this->newEmployeeForCos($r);
        }

        if($for == 'add_row'){
            return view('ajax.dynamic.'.\Illuminate\Support\Facades\Request::get('view'));
        }

        if($for == 'account'){
            $arr = [];
            $like = '%'.request('q').'%';
            $accounts = ChartOfAccounts::query()
                ->select('account_code' ,'account_title')
                ->where('account_code','like',$like)
                ->orWhere('account_title','like',$like)
                ->orderBy('account_title','asc');

            if(request()->has('page')){
                $accounts = $accounts->offset((request('page')-1)*10);
            }
            $accounts = $accounts->limit(10)
                ->get();

            if(!empty($accounts)){
                foreach ($accounts as $account){
                    array_push($arr,[
                        'id' => $account->account_code,
                        'text' => $account->account_title.' - '.$account->account_code,
                        'populate' => [
                            'account_title' => $account->account_title,
                            'account_code' => $account->account_code,
                        ]
                    ]);
                }
            }


            return Helper::wrapForSelect2($arr,true,$r);
        }

        if($for == 'ors_certified_by'){
            $data = null;
            $employees = Employee::query()
                ->select('lastname','firstname','middlename','position')
                ->where('is_active','ACTIVE')
                ->where(function($q){
                    $q->where('locations','=','VISAYAS')
                        ->orWhere('locations','=','LUZON/MINDANAO');
                })
                ->orderBy('salary_grade','desc')
                ->orderBy('firstname','asc');


            if($r->has('q') && $r->q != ''){
                $employees = $employees->where(function ($q) use ($r){
                    $q->where('lastname','like','%'.$r->q.'%')
                        ->orWhere('firstname','like','%'.$r->q.'%')
                        ->orWhere('middlename','like','%'.$r->q.'%');
                });
            }

            if($r->has('page')){
                $employees = $employees->offset((($r->page) - 1) * 10);
            }


            $employees = $employees->limit(10)->get();

            if($employees->count() > 0){
                $data = $employees->map(function ($data){
                    return [
                        'id' => $data->firstname.' '.Helper::middleInitial($data->middlename).' '.$data->lastname,
                        'text' => $data->firstname.' '.Helper::middleInitial($data->middlename).' '.$data->lastname,
                        'position' => $data->position,
                    ];
                });
                return Helper::wrapForSelect2($data->toArray());
            }
            return false;
        }

        if($for == 'pap'){
            $arr = [];
            $like = '%'.request('q').'%';
            $paps = Pap::query()
                ->select('pap_code' ,'pap_title', 'slug');
            if(request('respCode') != ''){
                $paps = $paps->where('resp_center','=',request('respCode'));
            }

            $paps = $paps->where(function ($q) use ($like){
                    $q->where('pap_code','like',$like)
                    ->orWhere('pap_title','like',$like);
                })
                ->orderBy('pap_code','asc')
                ->limit(10);
            if(request()->has('page')){
                $paps = $paps->offset((request('page')-1)*10);
            }
            $paps = $paps->get();

            if(!empty($paps)){
                foreach ($paps as $pap){
                    array_push($arr,[
                        'id' => $pap->pap_code,
                        'text' => $pap->pap_code.' | '.$pap->pap_title,
                        'slug' => $pap->slug,
                        'populate' => [
                            'pap_code' => $pap->pap_code,
                            'pap_title' => $pap->pap_title,
                        ]
                    ]);
                }
            }
            if($paps->count() >= 10){
                return Helper::wrapForSelect2($arr,true,$r);
            }else{
                return Helper::wrapForSelect2($arr,false,$r);
            }
        }

        if($for == 'ors_payees'){
            return $this->orsService->__typeAhead_payee($r);
        }

        //check for pap balances;

        if($for == 'ors_pap_balances'){
            $request = \Illuminate\Http\Request::capture();
            return $this->papService->getBalancesBySlug($request->slug);
        }

        if($for == 'orsAccountEntry'){
            if($r->type == 'DV'){
                $r->type = 'ORS';
            }else{
                $r->type = 'DV';
            }

            return view('ajax.dynamic.ors_account_entry')->with([
                'data' => $r,
            ]);
        }

        if($for == 'nextOrsNo'){
            $request = \Illuminate\Http\Request::capture();
            return $ORSService->newOrsNumber($request->fund);
        }

        if($for == 'documents_outgoing_control_no'){
            $documents = Document::query()
                ->orderBy('outgoing_control_no','desc')
                ->first();
            return  $documents->outgoing_control_no;
        }
    }

    private function applicant_filter_item_no(){
        $arr = [];
        $request = Request::capture();
        $ps = HRPayPlanitilla::query()->select('item_no','position')
            ->where('position','like','%'.$request->get('q').'%')
            ->orWhere('item_no','like','%'.$request->get('q').'%')
            ->groupBy('item_no')
            ->orderBy('item_no','asc');

        if($request->has('page')){
            $ps = $ps->offset((($request->page) - 1) * 10);
        }
        $ps = $ps->limit(10)
            ->get();
        if(!empty($ps)){
            foreach ($ps as $p){
                array_push($arr,[
                    'id' => $p->item_no,
                    'text' => $p->item_no.' - '.$p->position,
                ]);
            }
        }
        $request->add_null = true;
        return Helper::wrapForSelect2($arr,true,$request);
    }
    private function applicant_filter_position(){
        $arr = [];
        $request = Request::capture();
        $ps = ApplicantPositionApplied::query()->select('position_applied')
            ->where('position_applied','like','%'.$request->get('q').'%')
            ->groupBy('position_applied')
            ->orderBy('position_applied','asc');

        if($request->has('page')){
            $ps = $ps->offset((($request->page) - 1) * 10);
        }
        $ps = $ps->limit(10)
            ->get();
        if(!empty($ps)){
            foreach ($ps as $p){
                array_push($arr,[
                    'id' => $p->position_applied,
                    'text' => $p->position_applied,
                ]);
            }
        }
        $request->add_null = true;
        return Helper::wrapForSelect2($arr,true,$request);

    }
    private function compute_monthly_salary(){

        $latest = SSL::query()->orderBy('date_implemented','desc')->first();
        $latest_date_implemented = $latest->date_implemented;
        $ssl = SSL::query()->where('salary_grade','=',\request()->get('sg'))
            ->where('date_implemented','=',$latest_date_implemented)
            ->first();
        $si = 'step'.\request()->get('si');

        if(!empty($ssl->$si)){
            return number_format($ssl->$si,2);
        }
        else{
            return 'N/A';
        }
    }

    private function close_bulletin(){
        $last_slug = request('last_slug');
        Session::put('last_slug',$last_slug);

        return Session::get('last_slug');
    }

    private function newUserFromEmployee(Request $request){
        $arr = [];
        $employees = Employee::query()
            ->whereDoesntHave('user')
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->active();
        if($request->get('q') != ''){
            $employees = $employees
                ->where(function ($q) use ($request){
                    $q->where('lastname','like','%'.$request->get('q').'%')
                        ->orWhere('firstname','like','%'.$request->get('q').'%');
                });
        }
        if($request->has('page')){
            $employees = $employees->offset((($request->page) - 1) * 10);
        }
        $employees = $employees->limit(10)
            ->get();
        if($employees->count() > 0){
            foreach ($employees as $employee){
                array_push($arr,['id'=>$employee->slug,'text' => $employee->full['LFEMi']]);
            }
        }else{
            return  [];
        }


        $request->add_null = true;
        return Helper::wrapForSelect2($arr,true,$request);
    }

    private function clients(Request $request){
        $arr = [];
        $clients = Clients::query()
            ->orderBy('name');
        if($request->get('q') != ''){
            $clients = $clients
                ->where(function ($q) use ($request){
                    $q->where('name','like','%'.$request->get('q').'%')
                        ->orWhere('account_no','like','%'.$request->get('q').'%');
                });
        }
        $clients = $clients->paginate(25);
        if($clients->count() > 0){
            foreach ($clients as $client){
                array_push($arr,['id'=>$client->uuid,'text' => $client->name.' - '.$client->account_no]);
            }
        }else{
            return  [];
        }
        $request->add_null = true;
        return Helper::wrapForSelect2($arr,$clients->hasMorePages(),$request);
    }

    private function projectsGroupedByClients(Request $request)
    {

        $arr = [];
        $projects = Projects::query()
            ->with(['client'])
            ->orderBy('project_name');
        if($request->get('q') != ''){
            $projects = $projects
                ->where(function ($q) use ($request){
                    $q->where('project_code','like','%'.$request->get('q').'%')
                        ->orWhere('project_name','like','%'.$request->get('q').'%');
                });
        }
//        if($request->has('page')){
//            $projects = $projects->offset((($request->page) - 1) * 20);
//        }
//        $projects = $projects->limit(20)
//            ->get();
        $projects = $projects->paginate(25);
        $groupedByClient = $projects->groupBy('client.name');
        if($groupedByClient->count() > 0){
            foreach ($groupedByClient as $clientName => $projects){
                $children = [];
                foreach ($projects as $project){
                    $children[] = ['id'=>$project->uuid,'text' => $project->project_name.' - '.$project->project_code];
                }
                $arr[] = [
                    'text' => $clientName,
                    'children' => $children,
                ];
            }

        }else{
            return  [];
        }

//        $request->add_null = true;
        return Helper::wrapForSelect2($arr,true,$request);
    }

    private function invoicesGroupedByClients(Request $request)
    {

        $arr = [];
        $invoices = SalesInvoice::query()
            ->with(['client'])
            ->orderBy('invoice_no');
        if($request->get('q') != ''){
            $invoices = $invoices
                ->where(function ($q) use ($request){
                    $q->where('remarks','like','%'.$request->get('q').'%')
                        ->orWhere('invoice_no','like','%'.$request->get('q').'%');
                });
        }

        if($request->has('client') && $request->client != ''){
            $invoices = $invoices->where('client_uuid','=',$request->client);
        }

        $paginator = $invoices->paginate(25);
        $invoices = $paginator->getCollection();
        $groupedByClient = $invoices->groupBy('client.name');
        $color = [
            'CASH' => 'primary',
            'CHARGE' => 'success',
            'BILLING' => 'warning',
        ];
        if($groupedByClient->count() > 0){
            foreach ($groupedByClient as $clientName => $invoices){
                $children = [];
                foreach ($invoices as $invoice){

                    $html = '<span class="ms-3 float-end badge bg-'.($color[$invoice->ref_book] ?? 'secondary').'">'.$invoice->ref_book.'</span>';
                    $children[] = [
                        'id'=>$invoice->uuid,
                        'text' => $invoice->invoice_no.' - '.Str::limit($invoice->remarks,50),
                        'html' => $html,
                    ];
                }
                $arr[] = [
                    'text' => $clientName,
                    'children' => $children,
                ];
            }

        }else{
            $arr = [];
        }

//        $request->add_null = true;
        return Helper::wrapForSelect2($arr,$paginator->hasMorePages(),$request);
    }

    private function projectExpenseLiquadationDescription(Request $request){

        $cv = ProjectExpenseLiquidationDetails::query()
            ->select('description')
            ->groupBy('description')
            ->orderBy('description','asc');
        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('description','like','%'.$request->q.'%');
            });
        }

        $cv = $cv->paginate(25);
        $data = $cv->map(function ($data){
            return [
                'id' => $data->description,
                'text' => $data->description,
            ];
        })->toArray();
        $array = $data;

//        $request->add_null = true;
        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }

    private function stocks(Request $request){

        $data = null;
        $cv = Stocks::query()
            ->select('uuid','name','uom')
            ->orderBy('name','asc');
        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('name','like','%'.$request->q.'%')
                    ->orWhere('bar_code','like','%'.$request->q.'%');
            });
        }

        $cv = $cv->paginate(25);

        $data = $cv->map(function ($data){
            return [
                'id' => $data->uuid,
                'text' => $data->name,
                'uom' => $data->uom,
            ];
        })->toArray();
        $array = $data;
        /*
        if($cv->count() > 0){

            $data = $cv->map(function ($data){
                return [
                    'id' => $data->uuid,
                    'text' => $data->name,
                    'uom' => $data->uom,
                ];
            });

            $array = $data->toArray();

            $exists = 0;
            foreach ($array as $arr){
                if ($arr['id'] == $request->q){
                    $exists = 1;
                }
            }
            if($exists != 1){
                array_unshift( $array, [
                    'id' => $request->q,
                    'text' => $request->q,
                ] );
            }

        }else{

            $array = [];
            array_unshift( $array, [
                'id' => $request->q,
                'text' => $request->q,
            ] );

        }
        */
//        $request->add_null = true;
        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }

    private function banks(Request $request){

        $data = null;
        $cv = CollectionChecks::query()
            ->select('bank')
            ->orderBy('bank','asc')
            ->groupBy('bank');
        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('bank','like','%'.$request->q.'%');
            });
        }

        $cv = $cv->paginate(25);

        if($cv->count() > 0){

            $data = $cv->map(function ($data){
                return [
                    'id' => $data->bank,
                    'text' => $data->bank,
                ];
            });

            $array = $data->toArray();

            $exists = 0;
            foreach ($array as $arr){
                if ($arr['id'] == $request->q){
                    $exists = 1;
                }
            }
            if($exists != 1){
                array_unshift( $array, [
                    'id' => $request->q,
                    'text' => $request->q,
                ] );
            }

        }else{
            $array = [];
            array_unshift( $array, [
                'id' => $request->q,
                'text' => $request->q,
            ] );

        }
//        $request->add_null = true;
        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }

    private function accountCodes(Request $request){

        $data = null;
        $cv = \App\Models\FG\ChartOfAccounts::query()
            ->select('account_code','account_title')
            ->orderBy('account_title','asc');
        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('account_code','like','%'.$request->q.'%')
                ->orWhere('account_title','like','%'.$request->q.'%');
            });
        }

        $cv = $cv->paginate(25);

        $data = $cv->map(function ($data){
            return [
                'id' => $data->account_code,
                'text' => $data->account_title .' - '.$data->account_code,
            ];
        })->toArray();
        $array = $data;
        /*
        if($cv->count() > 0){

            $data = $cv->map(function ($data){
                return [
                    'id' => $data->account_code,
                    'text' => $data->account_title .' - '.$data->account_code,
                ];
            });

            $array = $data->toArray();

            $exists = 0;
            foreach ($array as $arr){
                if ($arr['id'] == $request->q){
                    $exists = 1;
                }
            }
            if($exists != 1){
                array_unshift( $array, [
                    'id' => $request->q,
                    'text' => $request->q,
                ] );
            }

        }else{
            $array = [];
            array_unshift( $array, [
                'id' => $request->q,
                'text' => $request->q,
            ] );

        }
        */
//        $request->add_null = true;
        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }
    private function subsidiaryAccountCodes(Request $request){

        $data = null;
        $cv = \App\Models\FG\SubsidiaryAccounts::query()
            ->select('account_code','account_title')
            ->orderBy('account_title','asc');
        if($request->has('parent_account_code') && filled($request->parent_account_code)){
            $cv = $cv->where('parent_account_code','=',$request->parent_account_code);
        }

        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('account_code','like','%'.$request->q.'%')
                    ->orWhere('account_title','like','%'.$request->q.'%');
            });
        }

        $cv = $cv->paginate(25);

        $data = $cv->map(function ($data){
            return [
                'id' => $data->account_code,
                'text' => $data->account_title .' - '.$data->account_code,
            ];
        })->toArray();
        $array = $data;
        /*
        if($cv->count() > 0){

            $data = $cv->map(function ($data){
                return [
                    'id' => $data->account_code,
                    'text' => $data->account_title .' - '.$data->account_code,
                ];
            });

            $array = $data->toArray();

            $exists = 0;
            foreach ($array as $arr){
                if ($arr['id'] == $request->q){
                    $exists = 1;
                }
            }
            if($exists != 1){
                array_unshift( $array, [
                    'id' => $request->q,
                    'text' => $request->q,
                ] );
            }

        }else{
            $array = [];
            array_unshift( $array, [
                'id' => $request->q,
                'text' => $request->q,
            ] );

        }
        */
//        $request->add_null = true;
        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }

    public function payor(Request $request)
    {

        $data = null;
        $cv = \App\Models\FG\Journals::query()
            ->select('counterparty')
            ->distinct()
            ->orderBy('counterparty','asc');

        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('counterparty','like','%'.$request->q.'%');
            });
        }

        $cv = $cv->paginate(25);

        $data = $cv->map(function ($data){
            return [
                'id' => $data->counterparty,
                'text' => $data->counterparty,
            ];
        })->toArray();
        $array = $data;

        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }

    private function newEmployeeForCos(Request $request){

        $arr = [];
        $employees = Employee::query()
            ->cos()
            ->whereDoesntHave('cosEmployees',function ($query) use ($request){
                $query->where('cos_slug',$request->cos);
            })
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->active()
            ->applyProjectId();
        if($request->get('q') != ''){
            $employees = $employees
                ->where(function ($q) use ($request){
                    $q->where('lastname','like','%'.$request->get('q').'%')
                        ->orWhere('firstname','like','%'.$request->get('q').'%');
                });
        }
        if($request->has('page')){
            $employees = $employees->offset((($request->page) - 1) * 10);
        }
        $employees = $employees->limit(10)
            ->get();
        if($employees->count() > 0){
            foreach ($employees as $employee){
                array_push($arr,['id'=>$employee->slug,'text' => $employee->full['LFEMi']]);
            }
        }else{
            return  [];
        }


        $request->add_null = true;
        return Helper::wrapForSelect2($arr,true,$request);
    }

    public function counterpartyInfo(Request $request)
    {
        $journals = Journals::query()->where('counterparty','=',$request->counterparty)->get();
        return view('fg-accounting.common.counterparty-info')->with([
            'journals' => $journals,
        ]);
    }



    private function orNos(Request $request)
    {

        $data = null;
        $cv = Collections::query()
            ->with([
                'client',
            ])
            ->select('uuid','ref_no','payment_type','client_uuid')
            ->orderBy('ref_no','asc');
        if($request->has('q') && $request->q != ''){
            $cv = $cv->where(function ($q) use ($request){
                $q->where('ref_no','like','%'.$request->q.'%');
            });
        }
        if($request->has('payment_type') && filled($request->payment_type)){
            $cv = $cv->where('payment_type','=',$request->payment_type);
        }

        $cv = $cv->paginate(25);

        $data = $cv->map(function ($data){
            return [
                'id' => $data->ref_no,
                'text' => $data->ref_no . ' - '.Helper::getInitials($data->payment_type),
                'client_uuid' => $data->client_uuid,
                'client' => $data->client,
                'collection_uuid' => $data->uuid,
            ];
        })->toArray();
        $array = $data;

        return Helper::wrapForSelect2($array,$cv->hasMorePages(),$request);
    }

    private function getNewJournalNo($request)
    {
        $journal = Journals::query()
            ->where('book','=',$request->book)
            ->orderBy('control_no','desc')
            ->first();
        $last = $journal->control_no ?? 0;
        return $last + 1;
    }
}