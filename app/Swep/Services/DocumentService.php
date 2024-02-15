<?php
 
namespace App\Swep\Services;

use App\Http\Controllers\DocumentController;
use App\Models\Document;
use App\Models\DocumentDisseminationLog;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

use App\Mail\DocumentDisseminationMail;

use App\Swep\Interfaces\DocumentInterface;
use App\Swep\Interfaces\DocumentDisseminationLogInterface;
use App\Swep\Interfaces\UserInterface;
use App\Swep\Interfaces\EmployeeInterface;
use App\Swep\Interfaces\EmailContactInterface;
use App\Swep\BaseClasses\BaseService;



class DocumentService extends BaseService{



    protected $document_repo;
    protected $ddl_repo;
    protected $user_repo;
    protected $employee_repo;
    protected $email_contact_repo;



    public function __construct(DocumentInterface $document_repo,
                                DocumentDisseminationLogInterface $ddl_repo,
                                UserInterface $user_repo,
                                EmployeeInterface $employee_repo,
                                EmailContactInterface $email_contact_repo
    ){

        $this->document_repo = $document_repo;
        $this->ddl_repo = $ddl_repo;
        $this->user_repo = $user_repo;
        $this->employee_repo = $employee_repo;
        $this->email_contact_repo = $email_contact_repo;
        parent::__construct();

    }






    public function fetch($request){

        $documents = $this->document_repo->fetch($request);

        $request->flash();
        return view('dashboard.document.index')->with('documents', $documents);

    }

    private function getStorage(){
        $auth = Auth::user();
        if($auth->project_id == 1){
            return Storage::disk('local');
        }else{
            return Storage::disk('qc_records');
        }
    }





    public function store($request){
            
        $fileext = File::extension($request->file('doc_file')->getClientOriginalName());

        $to = '';
        if (!empty($request->person_to)) {
            $to = " [TO ".$request->person_to."] - ";
        }
        $home = \Storage::disk('local')->getAdapter()->getPathPrefix();


        $filename = $request->reference_no .'-'.$to. $request->subject .'-'. $this->str->random(8).'.'.$fileext;

        $filename = $this->filterReservedChar($filename);

        $dir = $this->__dataType->date_parse($request->date, 'Y') .'/'. $request->folder_code;

        $dir2 = $this->__dataType->date_parse($request->date, 'Y') .'/'. $request->folder_code2;
        if (!is_dir($home.$this->__dataType->date_parse($request->date, 'Y'))) {
            // dir doesn't exist, make it
            mkdir($home.$this->__dataType->date_parse($request->date, 'Y'));
        }

        $request->slug = Str::random(16);
        $request->doc_id = $this->document_repo->getDocumentIdInc();
        $document_id = $request->doc_id;

        if(!is_null($request->file('doc_file'))){
            $type = 'QR';
            switch ($type){
                case 'BARCODE':
                    $barcode ='SRA-VIS-'.$request->reference_no;
                    $generator = new BarcodeGeneratorPNG();
                    $temp_barcode_dir = $home.'/BARCODE_TEMP/';
                    if (!is_dir($temp_barcode_dir)) {
                        // dir doesn't exist, make it
                        mkdir($temp_barcode_dir);
                    }

                    $image = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);

//            file_put_contents('D:/test.png',$image);


                    file_put_contents($temp_barcode_dir.$barcode.'.png', $image);

                    $image1 = $temp_barcode_dir.$barcode.'.png';
                    $pdf = new \setasign\Fpdi\Fpdi();


                    $totalPages = $pdf->setSourceFile($request->file('doc_file')->path());
                    $page_height = $pdf->GetPageHeight();
                    $page_width = $pdf->GetPageWidth();


                    for ($pageNo = 1;$pageNo <= $totalPages; $pageNo++){
                        $pdf->AddPage();
                        $tplIdx = $pdf->importPage($pageNo);

                        $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
                        $mainX = 10;
                        $mainY = 250;

                        $pdf->SetXY($mainX,$mainY);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Image($image1,$mainX,$mainY-15,40 , 10);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->SetXY($mainX-10,$mainY-3);

                        $pdf->Multicell(60,2    ,$barcode,0,"C");

                        $pdf->SetXY($mainX-10,$mainY-18);
                        $pdf->SetFont('Arial', '', '6');
                        $pdf->Multicell(60,2    ,"SUGAR REGULATORY ADMINISTRATION",0,"C");
                    }
                    break;

                case 'QR':


                    $barcode ='SRA-VIS-'.$request->reference_no;
                    $generator = new BarcodeGeneratorPNG();
                    $temp_barcode_dir = $home.'/BARCODE_TEMP/';
                    if (!is_dir($temp_barcode_dir)) {
                        // dir doesn't exist, make it
                        mkdir($temp_barcode_dir);
                    }

                    $image = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);
                    $image = QrCode::size('200')
                        ->format('png')
                        ->merge('/public/images/sra_only2.png',0.4)
                        ->errorCorrection('H')
                        ->generate(route("dashboard.document.view_file",$request->slug));



                    file_put_contents($temp_barcode_dir.$barcode.'.png', $image);

                    $image1 = $temp_barcode_dir.$barcode.'.png';
                    $pdf = new \setasign\Fpdi\Fpdi();

                    $totalPages = $pdf->setSourceFile($request->file('doc_file')->path());



                    for ($pageNo = 1;$pageNo <= $totalPages; $pageNo++){
                        $pdf->AddPage();
                        $tplIdx = $pdf->importPage($pageNo);


                        $page_height = $pdf->getTemplateSize($tplIdx)['height'];
                        $page_width = $pdf->getTemplateSize($tplIdx)['width'];

                        switch ($request->qr_location){
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
                            default:
                                $mainX = $page_width - 50;
                                $mainY = 20;
                                break;
                        }

                        //        UPPER RIGHT

                                                    //UPPER LEFT
                            //

                                                    //BOTTOM LEFT
                            //

                                                    //BOTTOM RIGHT
                    //



                        $pdf->useTemplate($tplIdx, 0, 0, null, null, true);

                        $pdf->SetXY($mainX,$mainY);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Image($image1,$mainX-20,$mainY-15,15 , 15);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->SetXY($mainX-5,$mainY-7);

                        $pdf->Multicell(60,2    ,$document_id,0,"L");
//                        $pdf->SetAlpha(0.5);
//                        $pdf->SetFillColor(191, 227,192);
//                        $pdf->Rect(20,40,20,30,'F');
//                        $pdf->SetAlpha(1);
                        $pdf->SetXY($mainX-5,$mainY-15);
                        $pdf->SetFont('Arial', '', '6');
                        $pdf->Multicell(60,2    ,"SUGAR REGULATORY ADMINISTRATION\nRECORDS SECTION\nDOCUMENT ARCHIVING SYSTEM",0,"L");
                    }
                break;

            }

            $directory =$home . $dir;
            if (!is_dir($directory)) {
                // dir doesn't exist, make it
                mkdir($directory);
            }

            $pdf->Output($directory.'/'.$filename, 'F');

            if (isset($request->folder_code2)) {
                $directory2 = $home . $dir2;
                if (!is_dir($directory2)) {
                    // dir doesn't exist, make it
                    mkdir($directory2);


                }
                $pdf->Output($directory2.'/'.$filename, 'F');
            }
        }

        $document = $this->document_repo->store($request, $filename);
        //$this->event->dispatch('document.store', $document);
        return redirect()->back();

    }






    public function show($slug){

        $document = $this->findBySlug($slug);
        return view('dashboard.document.show')->with('document', $document);

    }






    public function edit($slug){
        $document = $this->findBySlug($slug);
        return view('dashboard.document.edit')->with('document', $document);

    }







    public function update($request, $slug){


        $document = $this->document_repo->findBySlug($slug);

        $filename = $this->filename($request, $document);


        $new_dir = $this->__dataType->date_parse($request->date, 'Y') .'/'. $request->folder_code;
        $old_dir = $document->year .'/'. $document->folder_code;
        $new_file_dir = $this->__dataType->date_parse($request->date, 'Y') .'/'. $request->folder_code .'/'. $filename;
        $old_file_dir = $document->year .'/'. $document->folder_code .'/'. $document->filename;         

        $new_dir2 = $this->__dataType->date_parse($request->date, 'Y') .'/'. $request->folder_code2;
        $old_dir2 = $document->year .'/'. $document->folder_code2;
        $new_file_dir2 = $this->__dataType->date_parse($request->date, 'Y') .'/'. $request->folder_code2 .'/'. $filename;
        $old_file_dir2 = $document->year .'/'. $document->folder_code2 .'/'. $document->filename;


        // If theres new file upload
        if(!is_null($request->file('doc_file'))){

            //return 'if';
            if ($this->storage->disk('local')->exists($old_file_dir)) {
                $this->storage->disk('local')->delete($old_file_dir);
            }

            if (isset($request->folder_code2)) {
                if ($this->storage->disk('local')->exists($old_file_dir2)) {
                    $this->storage->disk('local')->delete($old_file_dir2); 
                }
            }
            
            $request->file('doc_file')->storeAs($new_dir, $filename);

            if (isset($request->folder_code2)) {
                $request->file('doc_file')->storeAs($new_dir2, $filename); 
            }


        }else{

            //return 'else';
            // If theres no file upload
            if($new_file_dir != $old_file_dir && $this->storage->disk('local')->exists($old_file_dir)){

                if($new_file_dir != $old_file_dir2 || $new_file_dir2 != $old_file_dir){

                    $this->storage->disk('local')->move($old_file_dir, $new_file_dir);

                }

            }



            if(isset($request->folder_code2) && $new_file_dir2 != $old_file_dir2){   

                if (isset($document->folder_code2) && $this->storage->disk('local')->exists($old_file_dir2)) {

                    if($new_file_dir != $old_file_dir2 || $new_file_dir2 != $old_file_dir){
                        $this->storage->disk('local')->move($old_file_dir2, $new_file_dir2);
                    }
                    
                }

                if (is_null($document->folder_code2) && $this->storage->disk('local')->exists($new_file_dir)) {
                    $this->storage->disk('local')->copy($new_file_dir, $new_file_dir2);
                }

            }



            if (is_null($request->folder_code2) && $this->storage->disk('local')->exists($old_file_dir2)) {
                $this->storage->disk('local')->delete($old_file_dir2);  
            }



        }
        $this->document_repo->update($request, $filename, $document);
        //$this->event->dispatch('document.update', $document);

        return redirect()->route('dashboard.document.index');

    }







    public function destroy($slug){

        $document = $this->document_repo->findBySlug($slug);
        
        $file_dir = $document->year .'/'. $document->folder_code .'/'. $document->filename;
        $file_dir2 = $document->year .'/'. $document->folder_code2 .'/'. $document->filename;

        if(!is_null($document->filename)){

            if ($this->storage->disk('local')->exists($file_dir)) {
                $this->storage->disk('local')->delete($file_dir);
            }

            if ($this->storage->disk('local')->exists($file_dir2)) {
                $this->storage->disk('local')->delete($file_dir2);
            }
        }

        $this->document_repo->destroy($document);

        //$this->event->dispatch('document.destroy', $document);

        return redirect()->back();

    }




    public function findBySlug($slug){
        $doc = Document::query()
            ->where('slug','=',$slug)
            ->first();
        return $doc ?? abort(503,'Doc not found');
    }

    public function viewFile($slug){

        $document = $this->findBySlug($slug);

        if(!empty($document->filename)){
//            $path = $this->__static->archive_dir() . $document->year .'/'. $document->folder_code .'/'. $document->filename;
            $path = $this->getStorage()->path('/'.$document->path.$document->filename);

//            return ;
//            if (!File::exists($path)) {
//                abort(504,'File does not exist.');
//            }
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = response()->make($file, 200);
//            $response->header("Content-Type", $type)
//                ->header('Content-disposition' => 'attachment; filename=' . $fileName,);
            $response->withHeaders([
                    'Content-Type' => $type,
                    'Content-disposition' => 'inline; filename='.$document->reference_no.'.pdf',
            ]);
            return $response;
        }

        return abort(404);
    }



    public function downloadDirect($request, $slug){

        $user = $this->user_repo->findBySlug($slug);  

        if ($request->username == $this->auth->user()->username && Hash::check($request->user_password, $this->auth->user()->password)) {

            $root_path = $this->__static->archive_dir() . $request->y .'/'. $request->fc;

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root_path), RecursiveIteratorIterator::LEAVES_ONLY);

            $zip = new ZipArchive();

            $zip->open($request->y .'-'. $request->fc .'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($files as $name => $file){

                if (!$file->isDir()){


                    $file_path = $file->getRealPath();

                    $relative_path = substr($file_path, strlen($root_path));

                    $rawFileName = substr($relative_path, strrpos($relative_path, "\\" )+1);
                    $doc = $this->document_repo->getToByFileName($rawFileName);
                    
                    
                    // echo $root_path;
                    // //echo $file_path;
                    // //echo $relative_path;
                   //return 1;
                    //$relative_path = $doc;

                    $filename = str_replace('.pdf', '', $relative_path);

                    $relative_path = str_replace(['?', '%', '*', ':', ';', '|', '"', '<', '>', '.', '//', '/'], '', $filename) .'.pdf';


                   


                    $zip->addFile($file_path, $relative_path);
                }

            } 
            $zip->close();
            return response()->download($request->y .'-'. $request->fc .'.zip')->deleteFileAfterSend();
        }
        $this->session->flash('USER_CONFIRMATION_FAIL', 'The credentials you provided does not match the current user!');
        return redirect()->back();
    }






    public function dissemination($request, $slug){

        $document = $this->document_repo->findBySlug($slug);


        return view('dashboard.document.dissemination')->with(['document'=>$document, 'request' => $request]);

    }


    public function print($slug){

        $document = $this->document_repo->findBySlug($slug);
        return view('printables.document.sent_mails')->with('document', $document);
    }



    public function disseminationPost($request, $slug){

        $document = $this->findBySlug($slug);

        //$path = $this->__static->archive_dir() . $document->year .'/'. $document->folder_code .'/'. $document->filename;
        $path = $this->getStorage()->path($document->path.$document->filename);

        $cc = []; //---> Array of recipients to be used for Logs
        $to_be_emailed = []; //---> Array of emails to be used for sending

        if(!empty($request->employee)){
            foreach ($request->employee as $employee_from_form) {

                $employee = $this->employee_repo->findByEmployeeNo($employee_from_form);

                if (filter_var($employee->email, FILTER_VALIDATE_EMAIL ) != false) {
                    $cc[$employee->employee_no] = [
                        "type" => "employee",
                        "email" => $employee->email
                    ]; 

                    array_push($to_be_emailed, $employee->email);
                }
                
            }
        }

        if(!empty($request->email_contact)){
            foreach ($request->email_contact as $email_contact_id) {
                $email_contact = $this->email_contact_repo->findByEmailContactId($email_contact_id);
                if (filter_var($email_contact->email, FILTER_VALIDATE_EMAIL ) != false) {
                    $cc[$email_contact_id] = [
                        "type" => "contact",
                        "email" => $email_contact->email
                    ];

                    array_push($to_be_emailed, $email_contact->email);
                }

            }
        }

        $content = "Good day. Please see the attached file. Thank you.";
        if($request->content != null){
            $content = $request->content;
        }


        $status = "PENDING";

        //Check for internet connection
        $connected = @fsockopen("www.google.com",80);
        $connected_2 = @fsockopen("www.yahoo.com",80);

//        if(!$connected){
//            if(!$connected_2){
//                return "<center style='font-family:Arial; color:red; padding-top:100px; font-size:26px'><b>No internet or Server not responding</b></center>";
//            }
//        }




        //SENDING EMAIL
        try {

            $this->mail->queue(new DocumentDisseminationMail($path, $request->subject, $document->filename, $to_be_emailed, $content));
            $status = "SENT";
        } catch (\Exception $e) {
            $status = "FAILED";
        }



        //STORING LOG TO DATABASE
        foreach ($cc as $key => $recepient) {

            if(empty($request->send_copy)){
                $send_copy = null;
            }else{
                if($request->send_copy == 1){
                    $send_copy = $request->send_copy;

                }else{
                    $send_copy = null;
                }
            }
            
            if($recepient['type'] == "employee"){
                $ddl = $this->ddl_repo->store($request, $key, null, $document->document_id, $recepient['email'], $status, $send_copy);
            }

            if($recepient['type'] == "contact"){
                $ddl = $this->ddl_repo->store($request, null, $key, $document->document_id, $recepient['email'], $status, $send_copy);
            }
        }

        return redirect()->back();

    }



 
    // Utils
    private function filename($request, $document){

        $filename = $document->filename;
        $fileext = File::extension($document->filename); 

        $to = '';
        if (!empty($request->person_to)) {
            $to = " [TO ".$request->person_to."] - ";
        }

        if($request->subject != $document->subject || $request->reference_no != $document->reference_no){
            
            $filename = $request->reference_no .'-'.$to. $request->subject .'-'. $this->str->random(8).'.'. $fileext;

        }elseif (!empty($request->file('doc_file'))) {
            
            $fileext = File::extension($request->file('doc_file')->getClientOriginalName());

            $filename = $request->reference_no .'-'.$to. $request->subject .'-'. $this->str->random(8).'.'. $fileext;

        }

        //added by GJ
        $filename = $request->reference_no .'-'.$to. $request->subject .'-'. $this->str->random(8).'.'. $fileext;

        return $this->filterReservedChar($filename);

    }





    private function filterReservedChar($filename){

        $fileext = File::extension($filename); 

        $filename = str_replace('.'. $fileext, '', $filename);

        $filename = $this->str->limit($filename, 150);

        $filename = str_replace(['?', '%', '*', ':', ';', '|', '"', '<', '>', '.', '//', '/'], '', $filename);

        $filename = stripslashes($filename);

        return $filename .'.'.$fileext;

    }



    public function report_generate($request){
        $logs =  $this->ddl_repo->getRaw()->with(['document']);
        $dt = null;
        $df = null;

        if(!empty($request->df) AND !empty($request->dt)){
            $df = date("Ymd",strtotime($request->df));
            $dt = date("Ymd",strtotime($request->dt ."+1 day"));
        }

        $logs = $logs
                ->where(function($q){
                    $q->where('send_copy','=',null)
                    ->orWhere('send_copy','=',0);
                })
                ->whereBetween('sent_at',[$df,$dt])
                ->get();

       

        //return $logs->sql();
        $logs_by_date = [];

        foreach ($logs as $key => $log) {

            if(!empty($log->document)){
                $logs_by_date[$this->ymd($log->sent_at)][$log->document->document_id]['found'][$log->slug] = $log;

                $logs_by_date[$this->ymd($log->sent_at)][$log->document->document_id]['subject'] = $log->document->subject;

                $logs_by_date[$this->ymd($log->sent_at)][$log->document->document_id]['reference_no'] = $log->document->reference_no;

                $logs_by_date[$this->ymd($log->sent_at)][$log->document->document_id]['person_to'] = $log->document->person_to;


            }else{
                $logs_by_date[$this->ymd($log->sent_at)]['UNKNOWN DOCUMENT']['found']['UNKNOWN DOCUMENT'] = $log;

                $logs_by_date[$this->ymd($log->sent_at)]['UNKNOWN DOCUMENT']['subject'] = 'UNKNOWN DOCUMENT';

                $logs_by_date[$this->ymd($log->sent_at)]['UNKNOWN DOCUMENT']['reference_no'] = 'UNKNOWN DOCUMENT';

                $logs_by_date[$this->ymd($log->sent_at)]['UNKNOWN DOCUMENT']['person_to'] = 'UNKNOWN DOCUMENT';
            }
        }
        //return $logs_by_date;
        //return $logs_by_date;
        return view("printables.document.disseminated_report")->with([
            'inclusive_dates' => [
                'from' => $df,
                'to' => date('Ymd',strtotime($dt.'-1 day'))
            ],

            'logs' => $logs_by_date
        ]);
        // return $documents->get();
    }

    private function ymd($var){
        return date("Ymd", strtotime($var));
    }

    public function rename_all(){
        
        
        $documents = $this->document_repo->getRaw()->get();
        //return $documents;
        $fn = [];
        foreach ($documents as $document) {
            array_push($fn, $document->reference_no);
            $req = new \Illuminate\Http\Request();

                
            $to = '';
            if (!empty($document->person_to)) {
                $to = "[TO ".$document->person_to."]-";
            }

            $filename = $document->reference_no .'-'.$to. $document->subject .'-'. $this->str->random(8).'.pdf';

            // $req->filename = $filename;
            // $req->person_to = $document->person_to;
            // $req->subject = $document->subject;
            // $req->reference_no = $document->reference_no;
            // $req->folder_code = $document->folder_code;

            $myRequest = new \Illuminate\Http\Request();
            $myRequest->setMethod('POST');
            $myRequest->request->add([
                'reference_no' => $document->reference_no,
                'date' => date_format($document->date,'m/d/Y'),
                'person_to' => $document->person_to,
                'person_from' => $document->person_from,
                'type' => $document->type,
                'folder_code' => $document->folder_code,
                'folder_code2' => $document->folder_code2,
                'remarks' => $document->remarks,
                'subject' => $document->subject,
            ]);
            $this->update($myRequest,$document->slug);
        }


        return 'Done rename All';
        



        // print("<pre>".print_r($fn,true)."</pre>");
        //return $this->document_repo->update_rename_all('a');
    }

    public function getRaw(){
        return $documents = $this->document_repo->getRaw();
    }

    public function disseminate2(Request $request){

        $doc = Document::query()
            ->where('slug','=',$request->document_slug)
            ->first();

        $path = $this->getStorage()->path($doc->path.$doc->filename);
        if($request->type == 'employee'){
            $employee = $this->employee_repo->findByEmployeeNo($request->employee);
            $email_contact = null;
        }else{
            $employee = null;
            $email_contact = $this->email_contact_repo->findByEmailContactId($request->employee);
        }
        $email = $employee->email ?? ($email_contact->email ?? null);

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = false;
        $mail->Host = 'mail.sra.gov.ph';
        $mail->SMTPAuth = true;
        $mail->Username = 'mail.no-reply@sra.gov.ph';
        $mail->Password = 'mail.no-reply';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->From = 'mail.no-reply@sra.gov.ph';
        $mail->FromName = 'SRA Web Portal - Document Dissemination';
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];


        $mail->isHTML();
        $mail->Subject = $request->subject ?? null;
//        $mail->addAddress('gguance221@gmail.com');
        $mail->addAddress($email);

        $ddl = new DocumentDisseminationLog();

        $ddl->slug = Str::random();
        $ddl->employee_no = $employee->employee_no ?? null;
        $ddl->email_contact_id = $email_contact->email_contact_id ?? null;
        $ddl->document_id = $doc->document_id;
        $ddl->email = $email;
        $ddl->subject = $request->subject;
        $ddl->content = $request->content;
        $ddl->status = 'SENT';
        $ddl->send_copy = $request->get('send_copy') ?? 0;
        $mail->Body =(
            $request->content ?? 'Good day. Please see the attached file.').
            view('dashboard.document.mail.footer')->with([
                'slug' => $ddl->slug,
            ])->render()
        ;
        $mail->addAttachment($path);

        if($mail->send()){
            $ddl->save();
            return 1;
        }
        abort(500,'asdsada');
    }

}