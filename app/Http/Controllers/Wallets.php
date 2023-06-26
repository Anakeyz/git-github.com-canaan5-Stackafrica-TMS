<?php

namespace App\Http\Controllers;

use App\Helpers\AppConfig;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Wallets extends Controller
{
    public function index()
    {
        return view('pages.wallets.index');
    }

    public function transactions()
    {
        return view('pages.wallets.transactions');
    }

    public function updateStatus(Wallet $wallet)
    {
        if (!$wallet->agent->is_active && !$wallet->is_active)
            return back()->with('error', "Failed! {$wallet->agent->email} is currently {$wallet->agent->status}");

        $wallet->changeStatus();

        return back()->with('success', "Wallet status updated for {$wallet->agent->email}.");
    }
}
