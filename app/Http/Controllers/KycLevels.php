<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Http\Requests\KycLevelRequest;
use App\Models\KycLevel;

class KycLevels extends Controller
{
    public function index()
    {
        return view('pages.kyc-level.index');
    }

    public function store(KycLevelRequest $request)
    {
        $data = $request->validated();

        KycLevel::create($data);

        return to_route('kyc-levels.index')->with('pending', 'New KYC Level awaiting approval.');
    }

    public function update(KycLevelRequest $request, KycLevel $kycLevel)
    {
        $kycLevel->update($request->validated());

        return to_route('kyc-levels.index')->with('pending', 'KYC Level update awaiting approval.');
    }

}
