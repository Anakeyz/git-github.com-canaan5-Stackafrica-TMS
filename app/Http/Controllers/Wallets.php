<?php

namespace App\Http\Controllers;

use App\Helpers\AppConfig;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Wallets extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read wallets');

        return view('pages.wallets.index');
    }
}
