<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\PettyCashLiquidationsFormRequest;
use App\Models\FG\PettyCashLiquidationAttachments;
use App\Models\FG\PettyCashLiquidations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PettyCashLiquidationController extends Controller
{
    private $folder;
    public function __construct()
    {
        $this->folder = 'fg.petty-cash-liquidations.';
    }

    public function userIndex(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $pettyCashLiquidations = PettyCashLiquidations::query()
                ->with([
                    'attachments'
                ]);
            return DataTables::of($pettyCashLiquidations)
                ->addColumn('action', fn($data) => view($this->folder.'dt-user-actions')->with(['data' => $data]))
                ->addColumn('attachments_view', fn($data) => view($this->folder.'dt-attachments')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'user-index');
    }
    public function edit($uuid)
    {
        $pcl = PettyCashLiquidations::query()
            ->with(['attachments'])
            ->findOrFail($uuid);
        return view($this->folder.'user-edit')->with([
            'pcl' => $pcl,
        ]);
    }

    public function update($uuid,PettyCashLiquidationsFormRequest $request)
    {
        $pettyCash = PettyCashLiquidations::query()->findOrFail($uuid);
        $pettyCash->date = $request->date;
        $pettyCash->total_amount = $request->total_amount;

        $savedFiles = [];
        if($request->hasFile('attachments')){
            foreach ($request->file('attachments') as $attachment){
                $mime = $attachment->getMimeType();
                $size = $attachment->getSize();

                $filename = Str::uuid().'.'.$attachment->getClientOriginalExtension();
                $path = Storage::disk('liquidation-attachments')
                    ->putFileAs('',$attachment,$filename);
                $savedFiles[] = [
                    'path' => $path,
                    'file_type' => strtolower($attachment->getClientOriginalExtension()),
                    'mime_type' => $mime,
                    'size' => $size,
                    'original_filename' => $attachment->getClientOriginalName(),
                ];
            }
        }

        try {
            DB::transaction(function () use($pettyCash,$savedFiles){
                $pettyCash->save();
                $pettyCash->attachments()->createMany($savedFiles);
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $pettyCash->only('uuid');
    }

    public function store(PettyCashLiquidationsFormRequest $request)
    {
        $pettyCash = new PettyCashLiquidations();
        $pettyCash->uuid = Str::uuid();
        $pettyCash->date = $request->date;
        $pettyCash->total_amount = $request->total_amount;

        $savedFiles = [];
        if($request->hasFile('attachments')){
            foreach ($request->file('attachments') as $attachment){
                $mime = $attachment->getMimeType();
                $size = $attachment->getSize();

                $filename = Str::uuid().'.'.$attachment->getClientOriginalExtension();
                $path = Storage::disk('liquidation-attachments')
                    ->putFileAs('',$attachment,$filename);
                $savedFiles[] = [
                    'path' => $path,
                    'file_type' => strtolower($attachment->getClientOriginalExtension()),
                    'mime_type' => $mime,
                    'size' => $size,
                    'original_filename' => $attachment->getClientOriginalName(),
                ];
            }
        }

        try {
            DB::transaction(function () use($pettyCash,$savedFiles){
                $pettyCash->save();
                $pettyCash->attachments()->createMany($savedFiles);
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $pettyCash->only('uuid');
    }

    public function show($uuid,Request $request)
    {
        if($request->has('showAttachment')){
            return $this->showAttachment($uuid,$request);
        }
    }
    public function showAttachment($uuid,Request $request)
    {
        $id = Crypt::decryptString($request->id);
        PettyCashLiquidations::query()->findOrFail($uuid);
        $attachment = PettyCashLiquidationAttachments::query()
            ->find($id);

        $disk = Storage::disk('liquidation-attachments');

        $fullPath = $disk->path($attachment->path);
        $mime = $disk->mimeType($attachment->path);
        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.$attachment->original_filename.'"'
        ]);
    }

    public function destroy($uuid,Request $request)
    {
        if($request->has('deleteAttachment')){
            return $this->deleteAttachment($request->key);
        }
        $pettyCash = PettyCashLiquidations::query()->findOrFail($uuid);

        try {
            DB::transaction(function () use ($pettyCash) {
                $pettyCash->delete();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return  1;
    }

    public function deleteAttachment($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $attachment = PettyCashLiquidationAttachments::query()->findOrFail($id);
        Storage::disk('liquidation-attachments')->delete($attachment->path);
        $attachment->delete();
        return response()->json(['success' => true]);
    }
}
