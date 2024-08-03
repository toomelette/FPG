<?php

namespace App\Http\Controllers;

use App\Models\DocumentDisseminationLog;
use App\Models\EmailContact;
use App\Swep\Helpers\Helper;
use App\Swep\Services\EmailContactService;
use App\Http\Requests\EmailContact\EmailContactFormRequest;
use App\Http\Requests\EmailContact\EmailContactFilterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EmailContactController extends Controller{




    protected $email_contact;




    public function __construct(EmailContactService $email_contact){

        $this->email_contact = $email_contact;

    }







    public function index(EmailContactFilterRequest $request){
        if($request->ajax() && $request->has('draw')){
            $contacts = EmailContact::query()
                ->withCount('documentDisseminationLog');
            return DataTables::of($contacts)
                ->addColumn('action',function($data){
                    return view('_records.email-contacts.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('logs',function($data){
                    return $data;
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return  view('_records.email-contacts.index');
        return $this->email_contact->fetch($request);
    }



    public function create(){
        return redirect(route('dashboard.email_contact.index')."?initiator=create");
    }

    


    public function store(EmailContactFormRequest $request){
        $contact = new EmailContact();
        $contact->slug = Str::random(16);
        $contact->email_contact_id = $this->getEmailContactIdInc();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->contact_no = $request->contact_no;
        if($contact->save()){
            return $contact->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function getEmailContactIdInc(){
        $id = 'EC10001';
        $email_contact = EmailContact::query()
            ->select('email_contact_id')
            ->orderBy('email_contact_id', 'desc')
            ->first();
        if($email_contact != null){

            if($email_contact->email_contact_id != null){
                $num = str_replace('EC', '', $email_contact->email_contact_id) + 1;
                $id = 'EC' . $num;
            }
        }
        return $id;
    }


    public function edit($slug){
        $contact = EmailContact::query()->findOrFail($slug);
        return  view('_records.email-contacts.edit')->with([
            'contact' => $contact,
        ]);
    }




    public function update(EmailContactFormRequest $request, $slug){
        $contact = EmailContact::query()->findOrFail($slug);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->contact_no = $request->contact_no;
        if($contact->update()){
            return $contact->only('slug');
        }
        abort(503,'Error saving data.');

    }

    


    public function destroy($slug){
        $contact = EmailContact::query()->findOrFail($slug);
        if($contact->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');

    }

    public function show($slug,Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $contact = EmailContact::query()->findOrFail($slug);
            $logs = DocumentDisseminationLog::query()
                ->with(['document'])
                ->where('email_contact_id','=',$contact->email_contact_id);
            return DataTables::of($logs)
                ->addColumn('file',function($data,DocumentController $documentController){
                    $storage = $documentController->getStorage();
                    return view('_records.email-contacts.show-dtFile')->with([
                        'document' => $data->document ?? null,
                        'storage' => $storage,
                    ]);
                })
                ->editColumn('content',function($data){
                    return Str::limit(strip_tags($data->content),150);
                })
                ->editColumn('sent_at',function($data){
                    return Helper::dateFormat($data->sent_at,'m/d/Y');
                })

                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        $contact = EmailContact::query()->findOrFail($slug);
        return view('_records.email-contacts.show')->with([
            'contact' => $contact,
        ]);
    }


    
}
