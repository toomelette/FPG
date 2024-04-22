<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFolder;
use App\Swep\Services\DocumentFolderService;
use App\Http\Requests\DocumentFolder\DocumentFolderFormRequest;
use App\Http\Requests\DocumentFolder\DocumentFolderFilterRequest;
use Illuminate\Http\Request;
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
                    return view('dashboard.document_folder.dtActions')->with([
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
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return  view('dashboard.document_folder.index');
        return $this->doc_folder->fetch($request);
        
    }

    public function download($slug){
        $document_folder = DocumentFolder::query()
            ->where('slug','=',$slug)
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
        $fileName = 'symlink/'.\Carbon::now()->format('Ymd-His').'.zip';
        if ($zip->open(($fileName), \ZipArchive::CREATE)== TRUE) {

            foreach ($documents as $document){
                if(\File::exists(env('STORAGE_LOCATION').$document->path.$document->filename)){
                    $zip->addFile(
                        env('STORAGE_LOCATION').$document->path.$document->filename,
                        $document->year.'/'.$document->filename,
                    );
                }
            }
            $zip->close();
        }

        return response()->download(public_path($fileName));
    }


    public function create(){
        
        return view('dashboard.document_folder.create');

    }

    



    public function store(DocumentFolderFormRequest $request){

        return $this->doc_folder->store($request);
        
    }

    



    public function edit($slug){
        
        return $this->doc_folder->edit($slug);

    }

    



    public function update(DocumentFolderFormRequest $request, $slug){
            
        return $this->doc_folder->update($request, $slug);

    }

    



    public function destroy($slug){
        
        return $this->doc_folder->destroy($slug);

    }

    



    public function browse($folder_slug,Request $request, DocumentController $documentController){
        $document_folder = DocumentFolder::query()
            ->where('slug',$folder_slug)
            ->first();
        $document_folder ?? abort(404,'Document Folder not found.');
        $folderCode = $document_folder->folder_code;
        if($request->ajax() && $request->has('draw')){
            $documents = Document::query()
                ->with(['folder','folder2'])
                ->where(function ($q) use ($folderCode){
                    $q->where('folder_code','=',$folderCode)
                        ->orWhere('folder_code2','=',$folderCode);
                });

            return $documentController->dataTable($request,$documents);
        }


        return view('dashboard.document_folder.browse')->with([
            'document_folder' => $document_folder,
        ]);
        return $this->doc_folder->browse($folder_code, $request);

    }







}
