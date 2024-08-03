<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFolder;
use App\Swep\Services\DocumentFolderService;
use App\Http\Requests\DocumentFolder\DocumentFolderFormRequest;
use App\Http\Requests\DocumentFolder\DocumentFolderFilterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;


class DocumentFolderController extends Controller{


   protected $doc_folder;



    public function __construct(DocumentFolderService $doc_folder){

        $this->doc_folder = $doc_folder;


    }





    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $df = DocumentFolder::query()
                ->withCount('documents1')
                ->withCount('documents2');
            return DataTables::of($df)
                ->addColumn('action',function($data){
                    return view('_records.document-folders.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('documents',function($data){
                    $ct =  ($data->documents1_count ?? 0) + $data->documents2_count ?? 0;
                    if($ct > 0){
                        return $ct;
                    }else{
                        return '-';
                    }
                })
                ->editColumn('retention_period',function($data){
                    if($data->retention_period != null){
                        $year = $data->retention_period / 12;
                        return $year . ' '. str_plural('year',$year) ;
                    }
                })
                ->editColumn('description',function($data){
                    return view('dashboard.document_folder.dtDescription')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return  view('_records.document-folders.index');
        return $this->doc_folder->fetch($request);
        
    }

    public function download($folder_code){


        $document_folder = DocumentFolder::query()
            ->where('folder_code','=',$folder_code)
            ->first();
        $document_folder ?? abort(404,'Document Folder not found.');
        $folderCode = $document_folder->folder_code;
        $documents = Document::query()
            ->where(function ($q) use ($folderCode){
                $q->where('folder_code','=',$folderCode)
                    ->orWhere('folder_code2','=',$folderCode);
            })
            ->get();

        $zip = new \ZipArchive();
        $fileName = 'symlink/temp/'.\Carbon::now()->format('Ymd-His').'.zip';
        if ($zip->open(($fileName), \ZipArchive::CREATE)== TRUE) {

            if(!empty($documents)){

                foreach ($documents as $document){
                    if(\File::exists(env('STORAGE_LOCATION').$document->path.$document->filename)){
                        $zip->addFile(
                            env('STORAGE_LOCATION').$document->path.$document->filename,
                            \Carbon::parse($document->date)->format('Y').'/'.$document->filename,
                        );
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


    public function create(){
        return  redirect(route('dashboard.document_folder.index')."?initiator=create");
        return view('dashboard.document_folder.create');

    }

    



    public function store(DocumentFolderFormRequest $request){

        $doc_folder = new DocumentFolder();
        $doc_folder->slug = Str::random();
        $doc_folder->folder_code = $request->folder_code;
        $doc_folder->description = $request->description;
        $doc_folder->retention_period = $request->retention_period;
        $doc_folder->is_permanent = $request->is_permanent == 0 ? null : $request->is_permanent;
        if($doc_folder->save()){
            return  $doc_folder->only('slug');
        }
        abort(503,'Error saving data.');
        
    }

    



    public function edit($slug){

        $folder = DocumentFolder::query()
            ->findOrFail($slug);
        return view('_records.document-folders.edit')->with([
            'folder' => $folder,
        ]);



    }

    



    public function update(DocumentFolderFormRequest $request, $slug){
        $docFolder = DocumentFolder::query()->find($slug) ?? abort(404);
        $docFolder->description = $request->description;
        $docFolder->retention_period = $request->retention_period;
        $docFolder->is_permanent = $request->is_permanent == 1 ? 1 : null;
        if($docFolder->update()){
            return $docFolder->only('slug');
        }
        abort(503,'Error updating Document Folder.');
    }

    



    public function destroy($slug){
        abort(503,'This feature is not yet available');
        $folder = DocumentFolder::query()
            ->findOrFail($slug);

        return $this->doc_folder->destroy($slug);

    }

    



    public function browse($folder_code,Request $request, DocumentController $documentController){
        $document_folder = DocumentFolder::query()
            ->where('folder_code','=',$folder_code)
            ->first();

        $document_folder ?? abort(404,'Document Folder not found.');
        $folderCode = $folder_code;
        if($request->ajax() && $request->has('draw')){
            $documents = Document::query()
                ->with(['folder','folder2'])
                ->where(function ($q) use ($folderCode){
                    $q->where('folder_code','=',$folderCode)
                        ->orWhere('folder_code2','=',$folderCode);
                });
            return $documentController->dataTable($request,$documents);
        }


        return view('_records.document-folders.browse')->with([
            'documentFolder' => $document_folder,
        ]);
        return $this->doc_folder->browse($folder_code, $request);

    }







}
