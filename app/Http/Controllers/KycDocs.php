<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Requests\KycDocRequest;
use App\Models\KycDoc;
use App\Models\User;
use Illuminate\Http\Request;

class KycDocs extends Controller
{

    public function index()
    {
        $kyc_docs = KycDoc::with('user')->latest()->paginate();

        return view('pages.kyc-docs.index', compact('kyc_docs'));
    }


    public function update(KycDocRequest $request, KycDoc $doc)
    {

    }

    public function destroy( KycDoc $kycDoc)
    {
        FileHelper::deleteUploadedFile($kycDoc->path);

        $kycDoc->delete();

        return back()->with('pending', 'Document deleted!');
    }
}

