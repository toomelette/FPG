<?php

namespace App\Http\Controllers\RECORDS;

use App\Http\Requests\DMS\DMSFormRequest;
use App\Models\Document;
use App\Models\RECORDS\DMSAttachment;
use App\Models\RECORDS\DMSFiles;
use App\Swep\Helpers\__static;
use App\Http\Controllers\Controller;
use App\Models\RECORDS\DMSDocuments;
use App\Swep\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DMSDocumentsController extends Controller
{
    public function index(Request $request){
        $documents = DMSDocuments::query();
        if ($request->ajax()){
            return $this->dataTable($request, $documents);
        }
        return view('_records.dms.index');
    }

    public function dataTable(Request $request, $documents){
        return datatables()->of($documents)
            ->editColumn('view_file', function ($data)  {
                return view('_records.dms.dtViewFile', [
                    'data' => $data->documentFiles,
                    'data2' => $data->AttachmentFiles,
                ]);
            })
            ->addColumn('action', function($data) {
                return view('_records.dms.dtActions', [
                    'data' => $data,
                ]);
            })
            ->editColumn('document_control_no', function ($data) {
                return nl2br(wordwrap($data->document_control_no ?? '', 30, "\n", true));
            })
            ->editColumn('document_title', function ($data) {
                return nl2br(wordwrap($data->document_title ?? '', 40, "\n", true));
            })

            ->editColumn('document_date',function($data){
                return Carbon::parse($data->document_date)->format('m/d/Y');
            })


            ->rawColumns(['document_date','action','document_title','document_control_no'])
            ->setRowId('slug')
            ->make();
    }

    public function addDmsDocument($slug){

        $document = DMSDocuments::query()
            ->where('slug', $slug)
            ->with(['documentFiles'])
            ->first();
            $document ?? abort(404,'Document not found.');

        return view('_records.dms.dtAddFile')->with([
            'document'=>$document,
        ]);
    }

    public function show(Request $request, $slug){
        $uploads = DMSFiles::query()
            ->where('slug',$slug)
            ->firstOrFail();
            $uploads ?? abort(404, 'Document not found.');
        $path = __static::archive_dir().'dms/'.$uploads->file_name;
        return response()->file($path);
    }
    public function viewDocumentFile($slug){
        $document = DMSFiles::where('slug', $slug)->firstOrFail();

        if (empty($document->document_file)) {
            return response()->json(['message' => 'No file uploaded'], 404);
        }

        $path = __static::archive_dir() . 'dms/' . $document->document_file;

        if (!\File::exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $type = \File::mimeType($path);

        // Handle download request
        if (request()->has('download')) {
            return $this->handleDownload($document, $path);
        }

        // Original logic
        if ($type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            return "Uploaded Document contains Word Download File to View";
        } elseif ($type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return "Uploaded Document contains Excel Download File to View";
        } else {
            $response = response()->make(\File::get($path), 500);
            $response->header("Content-Type", $type);
            return $response;
        }
    }

    public function showAttachment(Request $request, $slug){
        $uploads = DMSAttachment::query()
            ->where('slug',$slug)
            ->firstOrFail();
        $uploads ?? abort(404,'Document not found.');

        $path = __static::archive_dir().'dms/attachment/'.$uploads->document_attachment_file;
        return response()->file($path);
    }

    public function destroy($slug){
        $document = DMSDocuments::query()
            ->where('slug', $slug)
            ->first();
            $document ?? abort(404,'Document not found.');

        if($document->delete()){

            foreach ($document->documentFiles as $file) {
                if (!empty($file->file_name)) {
                    $path = '/external1/swep_afd_storage/'. . 'dms/' . $file->file_name;

                    if (file_exists($path)) {
                        unlink($path); // delete file physically
                    }
                }
            }
            foreach ($document->AttachmentFiles as $file) {
                if (!empty($file->document_attachment_file)) {
                    $path = '/external1/swep_afd_storage/'. . 'dms/attachment/' . $file->document_attachment_file;

                    if (file_exists($path)) {
                        unlink($path); // delete file physically
                    }
                }
            }
            $document->documentFiles()->delete();
            $document->AttachmentFiles()->delete();
            return 1;
        }
    }

    public function update(DMSFormRequest $request, DocumentRepository $documentRepository, $slug)
    {
        $path = Carbon::parse($request->date)->format('Y').'/'.$request->folder_code.'/';
        $path2 = null;
        if (!empty($request->folder_code2)) {
            $path2 = Carbon::parse($request->date)->format('Y').'/'.$request->folder_code2.'/';
        }

        $storage = $this->getStorage();
        $document_id = $documentRepository->getDocumentIdInc();

        // 🔹 Detect if selected is file or attachment
        [$type, $fileSlug] = explode(':', $request->selected_file);

        if ($type === 'file') {
            $selectedFile = DMSFiles::where('slug', $fileSlug)->firstOrFail();
            $sourcePath   = $selectedFile->path.'dms/'.$selectedFile->file_name;
            $sourceName   = $selectedFile->file_name;
        } elseif ($type === 'attachment') {
            $selectedFile = DMSAttachment::where('slug', $fileSlug)->firstOrFail();
            $sourcePath   = __static::archive_dir().'dms/attachment/'.$selectedFile->document_attachment_file;
            $sourceName   = $selectedFile->document_attachment_file;
        } else {
            abort(400, 'Invalid file type selected.');
        }

        // 🔹 Extension + new name
        $extension = pathinfo($sourceName, PATHINFO_EXTENSION);
        $new_file_name = $request->reference_no.'.'.$extension;

        // 🔹 Create document record
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

        // 🔹 Read file content (attachment might be local path, so use file_get_contents)
        if ($type === 'file') {
            $fileContent = $storage->get($sourcePath);
        } else {
            $fileContent = file_get_contents($sourcePath);
        }

        // 🔹 QR stamping
        if (!empty($request->qr_location)) {
            $this->makeQR($document, $document_id);
            $image1 = $storage->path('/QRCODE_TEMP/'.$document_id.'.png');
            $output = $this->stampPDFwithQR($request, $image1, $document_id);
        } else {
            $output = $fileContent;
        }

        // 🔹 Save to new disk
        $storage->put($path.'/'.$new_file_name, $output);

        if (!empty($request->folder_code2)) {
            $document->path2 = $path2;
            $storage->put($path2.'/'.$new_file_name, $output);
        }

        $document->filesize = $storage->fileSize($path.'/'.$new_file_name);
        $storage->delete('/QRCODE_TEMP/'.$document_id.'.png');

        if ($document->save()) {

            $this->destroy($slug);
            return $document->only('slug');
        }

        abort(503, 'Error saving data');
    }



    public function getStorage(){
        $auth = Auth::user();
        if($auth->project_id == 1){
            return Storage::disk('local');
        }else{
            return Storage::disk('qc_records');
        }
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
}
