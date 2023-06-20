<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        return MyResponse::success('Dashboard Loaded', [
            'wallet' => $user->wallet->only(['account_number', 'balance', 'status', 'updated_at']),
            'summary' => [
                'cashout_count' => Transaction::successful()->cashout()->count(),
                'transfer_count' => Transaction::successful()->transfer()->count(),
                'bill_payments_count' => Transaction::successful()->billPayment()->count()
            ],
            'menus' => $user->terminals->first()->menus()
                ->select(['services.id', 'slug', 'menu_name', 'description'])
                ->get()->makeHidden('pivot')
        ]);
    }
}
