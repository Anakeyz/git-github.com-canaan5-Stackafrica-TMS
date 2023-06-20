<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Helpers\Purchase;
use App\Helpers\WalletHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ElectricityPurchaseRequest;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Services\Electricity;
use Illuminate\Http\Request;

class ElectricityPurchase extends Controller
{
    public function index()
    {
        return MyResponse::success('Available distributors fetched',
            Electricity::provider()->distributors()->sortBy('name')->values());
    }

    public function show(Request $request, $meterNo)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'code' => 'required',
            'type' => 'required|in:prepaid,postpaid'
        ]);

        $service = Service::whereSlug(Electricity::NAME)->firstOrFail();
        $terminal = Terminal::whereSerial($request->get('serial'))->firstOrFail();

        $charge = $terminal->group->charge($service, $request->amount);

        $res = Electricity::provider()->validateMeter($meterNo, $request->code, $request->type, $request->amount);

        return MyResponse::success('Meter validated.', $res->put('charge', $charge));
    }

    public function store(ElectricityPurchaseRequest $request)
    {
        $provider = Electricity::provider();
        $service = Service::whereSlug(Electricity::NAME)->firstOrFail();

        $reference = General::generateReference();

        $phone = $request->get('phone');
        $amount = (double) $request->get('amount');
        $code = $request->get('code');
        $meter = $request->get('meterNo');

        $narration = 'Payment for ' . strtoupper($code)  ." electricity bill: $meter - " . moneyFormat($amount);

        $charge = $request->terminal->group->charge($service, $amount);
        $totalAmount = $amount + $charge;

        // save transaction
        $transaction = Transaction::createPendingFor(
            $request->terminal,
            $service,
            $amount,
            $totalAmount,
            $reference,
            $narration,
            $provider::name()
        );

        return Purchase::process($transaction, $request->wallet,
            fn () => WalletHelper::processDebit($request->wallet, $amount, $service, $reference, $narration, $charge),
            fn() => $provider->purchaseElectricity($amount, $phone, $reference, $request->paymentData)
        );
    }
}
