<?php

namespace App\Http\Controllers;

use App\Http\Requests\GlRequest;
use App\Models\GeneralLedger;
use App\Models\GLT;
use Illuminate\Http\Request;

class GeneralLedgers extends Controller
{
    public function index()
    {
        $gls = GeneralLedger::whereNot('service_id', 1)
            ->with('service')->get()->sortBy('service.name');

        return view('pages.general-ledger.index', compact('gls'));
    }

    public function show(GlRequest $request)
    {
//        Showing only cashout initially for the index route
        $gl = $request->gl;

//        $sum = $gl->glts()->groupBy('type')->selectRaw('type, sum(amount)')->pluck('sum(amount)', 'type');
        if ( $gl == null ) {
            $sum['CREDIT'] = 0;
            $sum['DEBIT'] = 0;

            $gl = new GeneralLedger();

            $service = collect([]);
            $service->id = 0;
            $service->name = '';

            $gl->id = 1;
            $gl->service_id = 1;
            $gl->balance = 0;
            $gl->service = $service;
        }
        else {
            $sum = $gl->glts()->groupBy('type')->selectRaw('type, sum(amount) as sum')->pluck('sum', 'type');
        }

        return view('pages.general-ledger.show', compact('gl', 'sum'));
    }

    public function update(GlRequest $request, GeneralLedger $gl)
    {
        $amount = $request->amount;
        $info = 'General Ledger was funded by ' . auth()->user()->name;

        $gl->recordTransaction('CREDIT', auth()->id(), $amount, $info);

        return back()->with('pending', 'Base Wallet funding awaiting Approval.');
    }
}
