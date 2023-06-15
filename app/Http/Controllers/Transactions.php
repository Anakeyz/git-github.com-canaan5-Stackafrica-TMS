<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Transactions extends Controller
{
    public function index(FilterRequest $request)
    {
//        $transactions = Transaction::latest()->with(['terminal', 'agent'])
//            ->filter($request->getFilterData())->paginate(self::pgNum());

        return view('pages.transactions.index');
    }
}
