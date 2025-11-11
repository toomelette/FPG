<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentDisseminationLog;
use App\Models\EmailContact;
use App\Models\Employee;
use App\Swep\Helpers\__static;
use App\Swep\Repositories\DocumentRepository;
use App\Swep\Services\DocumentService;
use App\Http\Requests\Document\DocumentFormRequest;
use App\Http\Requests\Document\DocumentFilterRequest;
use App\Http\Requests\Document\DocumentDownloadRequest;
use App\Http\Requests\Document\DocumentDisseminationRequest;
use Howtomakeaturn\PDFInfo\PDFInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Activitylog\Models\Activity;

class DocumentController extends Controller{



	protected $document;


    public function __construct(DocumentService $document){
        $this->document = $document;


    }



    
    public function index(DocumentFilterRequest $request){
        $documents = Document::with(['folder','folder2']);
        if ($request->ajax() && !empty($request->draw)){
            if(!empty($request->folder_code)){
                $documents->where('folder_code','=',$request->folder_code);
            }
            return $this->dataTable($request, $documents);
        }
        return view('_records.documents.index');
    }

    
    public function dataTable($request, $documents){

        if(!empty($request->type)){
            $documents->where('type','=',$request->type);
        }

        if(!empty($request->person_to)){
            $documents->where('person_to','=',$request->person_to);
        }
        if(!empty($request->person_from)){
            $documents->where('person_from','=',$request->person_from);
        }


        if(!empty($request->date_before)){
            $documents->where('date','<=',$request->date_before);
        }
        if(!empty($request->date_after)){
            $documents->where('date','>=',$request->date_after);
        }

        $storage = $this->getStorage();

        return \DataTables::of($documents)
            ->addColumn('view_document',function($data) use ($storage){
                return view('_records.documents.dtViewFile')->with([
                    'data' => $data,
                    'storage' => $storage,
                ]);
                if($storage->exists($data->path.$data->filename)){
                    if($data->folder->is_permanent){
                        $class = 'danger';
                        if(!empty($data->folder2)){
                            if($data->folder2->is_permanent){
                                $class = 'danger';
                            }
                        }
                    }else{
                        $class = 'success';
                    }
                    return '<a href="'.route("dashboard.document.view_file", $data->slug).'" class="btn btn-sm btn-'.$class.'" target="_blank">
                                    <i class="fa fa-file-o"></i>
                                  </a>';
                }else{

                    return '<button class="btn btn-sm btn-warning" title="File not found" disabled><i class="fa fa-exclamation-circle" ></i></button>';
                }
            })
            ->addColumn('action',function($data){
                return view('_records.documents.dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('date',function($data){
                return Carbon::parse($data->date)->format('m/d/Y');
            })
            ->editColumn('reference_no',function($data){
                return view('_records.documents.dtReferenceNo')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('subject',function($data){
                return view('_records.documents.dtSubject')->with([
                    'data' => $data,
                ]);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }

    public function create(){
        return redirect(route('dashboard.document.index').'?initiator=create');
    }

    public function getStorage(){
        $auth = Auth::user();
        if($auth->project_id == 1){
            return Storage::disk('local');
        }else{
            return Storage::disk('qc_records');
        }
    }


    public function store(DocumentFormRequest $request, DocumentRepository $documentRepository){

        $path = Carbon::parse($request->date)->format('Y').'/'.$request->folder_code.'/';
        $path2 = null;
        if(!empty($request->folder_code2)){
            $path2 = Carbon::parse($request->date)->format('Y').'/'.$request->folder_code2.'/';
        }

        $storage = $this->getStorage();

        $document_id = $documentRepository->getDocumentIdInc();

        $new_file_name = $request->reference_no.'.'.$request->file('doc_file')->getClientOriginalExtension();
        $document = new Document;
        $document->visibility = Auth::user()->access;
        $document->slug = Str::random();
        $document->reference_no = strtoupper($request->reference_no);
        $document->date = Carbon::parse($request->date)->format('Y-m-d');
        $document->person_from = $request->person_from;
        $document->person_to = $request->person_to;
        $document->type = $request->type;
        $document->subject = $request->subject;
        $document->path = $path;
        $document->filename = $new_file_name;
        $document->document_id = $document_id;
        $document->folder_code = $request->folder_code;
        $document->folder_code2 = $request->folder_code2;
        $document->remarks = $request->remarks;
        $document->qr_location = $request->qr_location;
        $document->outgoing_control_no = $request->outgoing_control_no;

        if(!empty($request->qr_location)){
            //Make QR
            $this->makeQR($document,$document_id);
            $image1 = $storage->path('/QRCODE_TEMP/'.$document_id.'.png');
            dd($request,$image1,$document_id);
            //Processed PDF
            $output = $this->stampPDFwithQR($request,$image1,$document_id);

        }else{
            $output = $request->file('doc_file')->get();
        }

        //Write to Disk
        $storage->put($path.'/'.$new_file_name,$output);
        //Cross filing
        if(!empty($request->folder_code2)){
            $document->path2 = $path2;
            $storage->put($path2.'/'.$new_file_name,$output);
        }
        $document->filesize = $storage->fileSize($path.'/'.$new_file_name);
        //Delete Temporary QR
        $storage->delete('/QRCODE_TEMP/'.$document_id.'.png');

        if($document->save()){

            return $document->only('slug');
        }
        abort(503,'Error saving data');
        return $this->document->store($request);
    }

    public  function makeQR($document,$document_id){
        //Make QR Code
        $image = QrCode::size('200')
            ->format('png')
            ->merge('/public/images/sra_only2.png',0.4)
            ->errorCorrection('H')
            ->generate(route("dashboard.document.view_file",$document->reference_no).'?trigger=SCANNER');
        //Store QR Code temporarily
        $this->getStorage()->put('/QRCODE_TEMP/'.$document_id.'.png',$image);
    }

    private function stampPDFwithQR($request,$image1,$document_id){
        $pdf = new \setasign\Fpdi\Fpdi();

        $totalPages = $pdf->setSourceFile($request->file('doc_file')->path());
        for ($pageNo = 1;$pageNo <= $totalPages; $pageNo++){
            $pdf->AddPage();
            $tplIdx = $pdf->importPage($pageNo);
            $page_height = $pdf->getTemplateSize($tplIdx)['height'];
            $page_width = $pdf->getTemplateSize($tplIdx)['width'];
            $mainX = $this->getXY($request->qr_location,$page_width,$page_height)['mainX'];
            $mainY = $this->getXY($request->qr_location,$page_width,$page_height)['mainY'];
            $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
            $pdf->SetAutoPageBreak(false);
            $pdf->SetXY($mainX,$mainY);
            if($pageNo < 2){

                $pdf->SetFont('Arial', '', '8');
                $pdf->Image($image1,$mainX-20,$mainY-15,15 , 15);
                $pdf->SetFont('Arial', '', '8');
                $pdf->SetXY($mainX-5,$mainY-7);
                $pdf->Multicell(60,2    ,$document_id,0,"L");
                $pdf->SetXY($mainX-5,$mainY-15);
                $pdf->SetFont('Arial', '', '6');
                $pdf->Multicell(60,2    ,"SUGAR REGULATORY ADMINISTRATION\nHUMAN RESOURCE & RECORDS SECTION\nDOCUMENT ARCHIVING SYSTEM",0,"L");

            }

        }
        return  $output = $pdf->Output('S');
    }
    private  function getXY($location,$page_width, $page_height){
        $mainX = $page_width - 50;
        $mainY = 20;

        switch ($location){
            case 'UPPER_RIGHT':
                $mainX = $page_width - 50;
                $mainY = 20;
                break;
            case 'UPPER_LEFT':
                $mainX = 30;
                $mainY = 20;
                break;
            case 'LOWER_RIGHT':
                $mainX = $page_width  - 50;
                $mainY = $page_height - 19;
                break;
            case 'LOWER_LEFT':
                $mainX = 30;
                $mainY = $page_height - 19;
                break;
            case 'LOWER_LEFT_PADDED':
                $mainX = 90;
                $mainY = $page_height - 10;
                break;
        }

        return [
            'mainX' => $mainX,
            'mainY' => $mainY,
        ];
    }


    public function show($slug){
        $document = $this->findBySlug($slug);
        return view('dashboard.document.show')->with([
            'document' => $document
        ]);
        return $this->document->show($slug);
        
    }




    public function edit($slug){
        $document = $this->findBySlug($slug);
        return view('_records.documents.edit')->with([
            'document' => $document
        ]);
        return $this->document->edit($slug);
        
    }




    public function update(DocumentFormRequest $request, $slug){
        $document = $this->findBySlug($slug);
        $document->reference_no = $request->reference_no;
        $document->date = Carbon::parse($request->date)->format('Y-m-d');
        $document->person_to = $request->person_to;
        $document->person_from = $request->person_from;
        $document->type = $request->type;
        $document->subject = $request->subject;
        $document->folder_code = $request->folder_code;
        $document->folder_code2 = $request->folder_code2;
        $document->remarks = $request->remarks;
        $document_year_folder = Carbon::parse($document->date)->format('Y');
        $request_year_folder = Carbon::parse($request->date)->format('Y');

        $new_filename = $document->filename;

        if($document->isDirty('date') || $document->isDirty('folder_code') || $document->isDirty('folder_code2') || $document->isDirty('reference_no')){
            $path = '';
            $path2 = '';

            if($document->isDirty('reference_no')){
                $new_filename = $request->reference_no.'.'.substr($document->filename, strrpos($document->filename, '.') + 1);

            }

            if($document_year_folder != $request_year_folder){
                $path = $request_year_folder.'/';
//                $path2 = $request_year_folder.'/';
            }else{
                $path = $document_year_folder.'/';
//                $path2 = $request_year_folder.'/';
            }

            if($document->isDirty('folder_code')){
                $path = $path.$request->folder_code.'/';
            }else{
                $path = $path.$document->folder_code.'/';
            }
            if($path != $document->path || $document->isDirty('reference_no')){
                $this->getStorage()->move($document->path.$document->filename,$path.$new_filename);
            }

            $document->path = $path;


            if(!empty($request->folder_code2)){
                if($document_year_folder != $request_year_folder){
                    $path2 = $request_year_folder.'/';
                }else{
                    $path2 = $request_year_folder.'/';
                }

                if($document->isDirty('folder_code2')){
                    $path2 = $path2.$request->folder_code2.'/';
                }else{
                    $path2 = $path2.$document->folder_code2.'/';
                }

                if($path2 != $document->path2 || $document->isDirty('reference_no')){
                    //IF PATH 2 IS CHANGED
                    if($this->getStorage()->exists($document->path2.$document->filename)){
                        $this->getStorage()->move($document->path2.$document->filename,$path2.$new_filename);
                    }else{
                        $this->getStorage()->copy($path.$new_filename,$path2.$new_filename);
                    }
                    $document->path2 = $path2;
                }
            }else{
                if($this->getStorage()->exists($document->path2.$new_filename)){
                    $this->getStorage()->delete($document->path2.$new_filename);
                }
                $document->path2 = null;
            }

        }
        $document->filename = $new_filename;
        if($document->update()){
            return $document->only('slug');
        }
        return 1;
        if($document->isDirty('folder_code')){

            return 'dirty';
        }else{
            return 'clean';
        }
        //$document->update();
        return $request;
        //return $this->document->update($request, $slug);

    }

    


    public function destroy($slug, Request $request){

        if(!Hash::check($request->password,Auth::user()->password)){
            abort(503, 'Incorrect password.');
        }

        $document = $this->findBySlug($slug);
        if($this->getStorage()->exists($document->path.$document->filename)){
            $this->getStorage()->move($document->path.$document->filename,$document->path.$document->filename.'.x');
           // $this->getStorage()->delete($document->path.$document->filename);
        }
        if($this->getStorage()->exists($document->path2.$document->filename)){
            $this->getStorage()->move($document->path2.$document->filename,$document->path2.$document->filename.'.x');
            //$this->getStorage()->delete($document->path2.$document->filename);
        }

        if($document->delete()){
            return 1;
        }
       return $this->document->destroy($slug); 

    }




    public function viewFile($slug){
        $request_slug = \Illuminate\Support\Facades\Request::get('slug');

        if(empty(\Illuminate\Support\Facades\Request::get('slug'))){
            $document = $this->findBySlug($slug);

            if(!empty($document)){
                $rt = route('dashboard.document.view_file',$document->reference_no).'?slug='.$slug;
                return redirect($rt);
            }
        }
        return $this->document->viewFile($request_slug);

    }

    public function findByRefNo($ref_no){
        $document = Document::query()->where('reference_no','=',$ref_no)->first();
        if(!empty($document)){
            return $document;
        }
        abort(503);
    }

    public function findBySlug($slug){
        $d = Document::query()
            ->with(['folder','folder2'])
            ->where('slug','=',$slug)
            ->first();
        if(!empty($d)){
            return $d;
        }
        abort(503,'Document does not exits in the database.');
    }


    public function download(){

        $ys = [];
        $years = $this->document->getRaw()->groupBy('year')->orderBy('year','asc')->pluck('year'); 
        foreach ($years as $year) {
            $ys[$year] = $year;
        }
        return view('_records.documents.download')->with(['years'=> $ys]);

    }

    public function downloadPost(Request $request){

        $documents = Document::query();

        if(($request->has('date_from') && $request->date_from != '') || $request->has('date_to') && $request->date_to != ''){
            $documents = $documents->where(function ($q) use ($request){
                $q->where('date','>=',$request->date_from)
                    ->where('date','<=',$request->date_to);
            });
        }

        if($request->has('document_type') && $request->document_type != ''){
            $documents = $documents->where('type','=',$request->document_type);
        }

        if($request->has('person_from') && $request->person_from != ''){
            $documents = $documents->where('person_from','=',$request->person_from);
        }
        if($request->has('person_to') && $request->person_to != ''){
            $documents = $documents->where('person_to','=',$request->person_to);
        }

        $documents = $documents->get();

        $fieldForFolder = '';
        switch ($request->type){
            case 'by_year':
                $fieldForFolder = 'year';
                break;
            case 'by_to':
                $fieldForFolder = 'person_to';
                break;
            case 'by_from':
                $fieldForFolder = 'person_from';
                break;
            case 'by_folder_code':
                $fieldForFolder = 'folder_code';
                break;
            case 'by_document_type':
                $fieldForFolder = 'type';
                break;
            default:
                abort(504,'Please select folders.');
                break;
        }

        $zip = new \ZipArchive();
        $fileName = 'symlink/temp/'.\Carbon::now()->format('Ymd-His').'.zip';
        $max = 10000000;
        $ct = 0;
        if ($zip->open(($fileName), \ZipArchive::CREATE)== TRUE) {

            if(!empty($documents)){

                foreach ($documents as $document){
                    if($ct < $max){
                        if(\File::exists(env('STORAGE_LOCATION').$document->path.$document->filename)){
                            if($request->type = 'by_year'){
                                $folder = Carbon::parse($document->date)->format('Y');
                            }else{
                                $folder = str_replace('/',' or ',$document->$fieldForFolder);
                            }

                            $zip->addFile(
                                env('STORAGE_LOCATION').$document->path.$document->filename,
                                $folder.'/'.$document->filename,
                            );
                            $ct ++;
                        }
                    }

                }
            }
            if($zip->numFiles > 0){
                $zip->close();
            }
        }

        if(\File::exists(public_path($fileName))){
            return response()->download(public_path($fileName));
        }
        abort(503,'No files found.');
    }



    public function downloadDirect(DocumentDownloadRequest $request, $slug){

       return $this->document->downloadDirect($request, $slug); 

    }




    public function dissemination(Request $request, $slug){
        $document = Document::query()
            ->where('slug','=',$slug)
            ->first();

        if(!$this->document->checkIfExistsInPath($document)){
            abort(510,'Document not found in the storage.');
        }
        $emailContacts = EmailContact::query()->get();
        $emailContacts = $emailContacts->mapWithKeys(function ($data){return[$data->email_contact_id => $data->name .' | '.$data->email];});
        $employeesWithEmail = Employee::query()
            ->where('email','!=',null)
            ->where('email','!=','')
            ->active()
            ->get()
            ->mapWithKeys(function ($data){
                return [
                    $data->slug => $data->full['LFEMi'] .' | '. $data->email,
                ];
            });


        return view('_records.documents.dissemination')->with([
            'document'=>$document,
            'request' => $request,
            'emailContacts' => $emailContacts,
            'employeesWithEmail' => $employeesWithEmail,
        ]);
    }





    public function disseminationPost(DocumentDisseminationRequest $request, $slug){
        if(Auth::user()->project_id == 2){
            $r = collect([
                'subject' => $request->subject,
                'employees' => $request->employee,
                'email_contacts' => $request->email_contact,
                'content' => $request->body,
            ]);

            return view('dashboard.document.dissemination_status')->with([
                'r' => $r,
                'slug' => $slug,
                'send_copy' => $request->send_copy ?? 0,
            ]);
        }

       return $this->document->disseminationPost($request, $slug); 
       
    }

    public function mailSingle(Request $request){

        return $this->document->disseminate2($request);
    }
    public function print($slug)
    {
        return $this->document->print($slug); 
    }

    public function report(){
        return view('_records.documents.reports');
    }
    
    public function report_generate(Request $request){

        $activity = activity()
            ->performedOn(new Document())
            ->causedBy(Auth::user()->id)
            ->withProperties(['attributes' => 'Generated report on Document Dissemination.'])
            ->log('generated');

        return $this->document->report_generate($request);
    }

    public function rename_all(){
        //return 1;
        return $this->document->rename_all();
    }

    public function printQr($slug,Request $request){

        $document = $this->findBySlug($slug);
        $storage = $this->getStorage();
        $this->makeQR($document,$document->document_id);
        $path = '/QRCODE_TEMP/'.$document->document_id.'.png';


        if($request->has('print_as_tag') && $request->print_as_tag == true){
            return view('dashboard.document.outgoing_tag')->with([
                'document' => $document,
            ]);
        }else{
            return view('dashboard.document.print_qr')->with([
                'document' => $document,
            ]);
        }
    }
    public function getQr($slug){
        //    $path = storage_path('public/' . $filename);

        $storage = $this->getStorage();
        dd($storage);
        $document = \App\Models\Document::query()->where('slug','=',$slug)->first();
        $path = 'RECORDS_QC/QRCODE_TEMP/'.$document->document_id.'.png';
        if($storage->exists($path)){
            $file = $storage->get($path);
            $type = $storage->getMimetype($path);
            $response = \Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        }
        abort(503,'FILE DOES NOT EXIST');
    }

    public function received($slug){
        $ddl = DocumentDisseminationLog::query()->where('slug','=',$slug)->first();
        $ddl ?? abort(404,'Page not found');

        if($ddl->received_at == null){
            $ddl->received_at = Carbon::now();
            $ddl->save();
        }

        return view('dashboard.document.received');
    }
}
