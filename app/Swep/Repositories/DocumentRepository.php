<?php

namespace App\Swep\Repositories;
 
use App\Models\SuSettings;
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\DocumentInterface;


use App\Models\Document;
use Illuminate\Support\Facades\Auth;


class DocumentRepository extends BaseRepository implements DocumentInterface {
	



    protected $document;




	public function __construct(Document $document){

        $this->document = $document;
        parent::__construct();

    }






    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $df = $this->__dataType->date_parse($request->df);
        $dt = $this->__dataType->date_parse($request->dt);

        $document = $this->document->newQuery();

        $parsed_date = $this->__dataType->date_parse($request->d);

        if(isset($request->q)){
            $this->search($document, $request->q);
        }

        if(isset($request->fc)){
            $document->where('folder_code', $request->fc)
                ->orWhere('folder_code2', $request->fc);
        }

        if(isset($request->dct)){
            $document->whereType($request->dct);
        }

        if(isset($request->df) || isset($request->dt)){
            $document->whereBetween('date', [$df, $dt]);
        }

        return $this->populate($document, $entries);


        $documents = $this->cache->remember('documents:fetch:' . $key, 240, function() use ($request, $entries){

            $df = $this->__dataType->date_parse($request->df);
            $dt = $this->__dataType->date_parse($request->dt);

            $document = $this->document->newQuery();
            
            $parsed_date = $this->__dataType->date_parse($request->d);

            if(isset($request->q)){
                $this->search($document, $request->q);
            }

            if(isset($request->fc)){
                $document->where('folder_code', $request->fc)
                         ->orWhere('folder_code2', $request->fc);
            }

            if(isset($request->dct)){
                $document->whereType($request->dct);
            }

            if(isset($request->df) || isset($request->dt)){
                $document->whereBetween('date', [$df, $dt]);
            }

            return $this->populate($document, $entries);

        });

        return $documents;

    }







    public function fetchByFolderCode($folder_code, $request){


        $key = str_slug($request->fullUrl(), '_');
        $document = $this->document->newQuery();
        $document = $document->select('subject','person_to','reference_no', 'slug', 'updated_at');

        if($request->q != null || $request->q != ''){
            $document =  $document->where('subject','LIKE','%'.$request->q.'%');
        }

        $document = $document->where(function($query) use ($folder_code){
            $query->where('folder_code', $folder_code)
                ->orwhere('folder_code2', $folder_code);
        });


        $document = $document
            ->sortable()
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        return $document;

        $documents = $this->cache->remember('documents:fetchByFolderCode:' . $key, 240, function() use ($folder_code, $request){

            $document = $this->document->newQuery();
            $document = $document->select('subject','person_to','reference_no', 'slug', 'updated_at');

            $document =  $document->where('subject','LIKE','%'.$request->q.'%');


            $document = $document->where(function($query) use ($folder_code){
                $query->where('folder_code', $folder_code)
                        ->orwhere('folder_code2', $folder_code);
            });


            $document = $document
                            ->sortable()
                            ->orderBy('updated_at', 'desc')
                            ->paginate(20);
            return $document;
        });  


        return $documents;

    }







    public function store($request, $filename){

        $document = new document;
//        $document->slug = $this->str->random(32);
        $document->slug = $request->slug;
        $document->document_id = $request->doc_id;
        $document->filename = $filename;
        $document->reference_no = $request->reference_no;
        $document->date = $this->__dataType->date_parse($request->date);
        $document->person_to = $request->person_to;
        $document->person_from = $request->person_from;
        $document->type = $request->type;
        $document->subject = $request->subject;
        $document->folder_code = $request->folder_code;
        $document->folder_code2 = $request->folder_code2;
        $document->remarks = $request->remarks;
        $document->year = $this->__dataType->date_parse($request->date, 'Y');
        $document->created_at = $this->carbon->now();
        $document->updated_at = $this->carbon->now();
        $document->ip_created = request()->ip();
        $document->ip_updated = request()->ip();
        $document->user_created = $this->auth->user()->user_id;
        $document->user_updated = $this->auth->user()->user_id;
        $document->save();

        return $document;

    }






    public function update($request, $filename, $document){

        if(isset($filename)){
            $document->filename = $filename;      
        }

        $document->reference_no = $request->reference_no;
        $document->date = $this->__dataType->date_parse($request->date);
        $document->person_to = $request->person_to;
        $document->person_from = $request->person_from;
        $document->type = $request->type;
        $document->subject = $request->subject;
        $document->folder_code = $request->folder_code;
        $document->folder_code2 = $request->folder_code2;
        $document->remarks = $request->remarks;
        $document->year = $this->__dataType->date_parse($request->date, 'Y');
        $document->updated_at = $this->carbon->now();
        $document->ip_updated = request()->ip();
        $document->user_updated = $this->auth->user()->user_id;
        $document->save();

        return $document;
        
    }




    public function destroy($document){

        $document->delete();
        return $document;
        
    }






    public function findBySlug($slug){

        $document = Document::query()
            ->where('slug','=', $slug)
            ->with([
                'documentDisseminationLog',
//                'documentDisseminationLog.employee',
//                'documentDisseminationLog.emailContact',
            ])
            ->first() ?? abort(503,'Document not found');

        if(empty($document)){
            abort(404);
        }
        
        return $document;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('reference_no', 'LIKE', '%'. $key .'%')
                      ->orwhere('person_to', 'LIKE', '%'. $key .'%')
                      ->orwhere('person_from', 'LIKE', '%'. $key .'%')
                      ->orwhere('subject', 'LIKE', '%'. $key .'%')
                      ->orwhere('remarks', 'LIKE', '%'. $key .'%');
        });

    }






    public function populate($model, $entries){

        return $model->select('filename', 'folder_code','folder_code2', 'reference_no', 'date', 'person_to', 'person_from', 'subject', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate($entries);

    }






    public function getDocumentIdInc(){
        $user = Auth::user();
        if($user->project_id == 1){
            $prefix = 'SRA-VIS-';
        }else{
            $prefix = 'SRA-QC-';
        }
        $id = $prefix.$user->project_id.'0000001';
        $document = $this->document->select('document_id')
            ->where('document_id','like',$prefix.'%')
            ->orderBy('document_id', 'desc')
            ->withTrashed()
            ->first();
        if($document != null){
            if($document->document_id != null){
                $num = preg_replace("/[^0-9]/", "", $document->document_id)+1;
                $id = $prefix. $num;
            }
        }
        return $id;
    }



     public function getRaw(){
        return $this->document;
    }



    public function getToByFileName($filename){
        $document = $this->document->where('filename',$filename)->first();
        return $document;
    }
}