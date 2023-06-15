<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\WalletTransaction;
use Illuminate\Validation\Rule;

class Ledger extends Controller
{
    public function index(FilterRequest $request)
    {
        return view('pages.ledger.index');
    }
}
