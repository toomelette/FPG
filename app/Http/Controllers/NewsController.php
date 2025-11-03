<?php


namespace App\Http\Controllers;




use App\Http\Requests\News\NewsFormRequest;
use App\Models\News;
use App\Models\NewsAttachments;
use App\Swep\Helpers\__static;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    public function index(){
        if(request()->ajax() && request()->has('draw')){
            $news = News::query()->with('attachments');
            return DataTables::of($news)
                ->addColumn('action',function ($data){
                    $destroy_route = "'".route("dashboard.news.destroy","slug")."'";
                    $slug = "'".$data->slug."'";
                    return '<div class="btn-group">
                                <button type="button" onclick="delete_data('.$slug.','.$destroy_route.')" data="'.$data->slug.'" class="btn btn-sm btn-danger" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>';
                })
                ->addColumn('attachments',function ($data){
                    $return = '';
                    if($data->attachments->count() > 0){
                        foreach ($data->attachments as $attachment){
                            $return = $return.'<a href="'.route('dashboard.news.view_doc',$attachment->slug).'" target="_blank"><p class="no-margin text-info" style="margin-bottom: 10px !important;"><i class="fa fa-paperclip"></i> '.$attachment->file.'</p></a>';
                        }
                    }else{
                        $return = 'No attachment.';
                    }
                    return $return;
                })
                ->editColumn('expires_on',function ($data){
                    if(Carbon::parse($data->expires_on) < Carbon::now()){
                        return Carbon::parse($data->expires_on)->format('F d, Y h:i A') . '<small class="label pull-right bg-red">EXPIRED</small>';
                    }
                    return Carbon::parse($data->expires_on)->format('F d, Y h:i A');
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->make(true);
        }
        return view('dashboard.news.index');
    }

    public function store(NewsFormRequest $request){
        $ct = 0;
        $news = new News;
        $news->slug = Str::random();
        $news->title = $request->title;
        $news->details = $request->details;
        $news->expires_on = Carbon::parse($request->expires_on)->format('Y-m-d H:i:s');
        $news->author = $request->author;
        $news->author_position = $request->author_position;
        $news->is_active = 1;
        if($news->save()){
        $attachmentsArray = [];
            if(!empty($request->doc_file)){
                foreach ($request->file('doc_file') as $file){
                    $original_ext = $file->getClientOriginalExtension();
                    $original_file_name_only = str_replace('.'.$original_ext,'',$file->getClientOriginalName());
                    $new_file_name_full = $original_file_name_only.'-'.Str::random(10).'.'.$original_ext;
                    //Storage::disk('local')->putFileAs('news/',$file,$new_file_name_full);

                    $file->storeAs('news/',$new_file_name_full);
                    $arr = [
                        'slug' => Str::random(),
                        'news' => $news->slug,
                        'file' => $new_file_name_full,
                        'original_file_name' => $original_file_name_only.'.'.$original_ext,
                        'created_at' => Carbon::now(),
                    ];
                    array_push($attachmentsArray,$arr);
                }
                NewsAttachments::query()->insert($attachmentsArray);
            }

            return $news->only('slug');
        }

        abort(503, 'Error saving data.');
    }

    private function findBySlug($slug){
        $news = News::query()->with('attachments')->where('slug','=',$slug)->first();

        if(!empty($news)){
            return $news;
        }
        abort(503,'News not found');
    }

    public function viewDoc($id){

        $attachment = NewsAttachments::query()->findOrFail($id);
        $filename = $attachment->file;

        if(\request()->has('download')){
            return $dl = Storage::disk('local')->download('news/'.$filename);
        }
        $storage = Storage::disk('news');
        if ($storage->exists($filename)){
            return  $storage->response($filename);
        }
        abort(404);
    }
    public function show($slug)
    {
        $news = News::findOrFail($slug);
        return view('_su.news.show')->with([
            'news' => $news
        ]);
    }
    public function destroy($slug){
        $news = $this->findBySlug($slug);

        if($news->attachments->count() > 0){
            foreach ($news->attachments as $attachment){
                $filename = $attachment->file;
                $path = __static::archive_dir().'news/'.$filename;
                if(File::exists($path)){
                    File::delete($path);
                }
            }
        }
        $news->attachments()->delete();
        if($news->delete()){
            return 1;
        }
    }
}