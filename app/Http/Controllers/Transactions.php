<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transactions extends Controller
{
    public function index(FilterRequest $request)
    {
        $request->user()->can('read transactions');

        return view('pages.transactions.index');
    }
}
