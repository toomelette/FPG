<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Scopes\ProjectScope;
use Illuminate\Http\Request;

class VerifierController extends Controller
{
    public function verifyDocument(Request $request)
    {
        $document = Document::query()
            ->where('reference_no','=',$request->document)
            ->withoutGlobalScopes()
            ->first();
        return view('_public.verify-document')->with([
            'document' => $document,
        ]);
        dd($document);
        dd($request->all());
    }
}