<?php

use App\Http\Controllers\Api\Authenticate;
use App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Api\Logout;
use App\Http\Controllers\Api\Transactions;
use App\Http\Controllers\Api\WalletTransactions;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('auth',         Authenticate::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('dashboard', Dashboard::class);

        Route::apiResource('transactions',              Transactions::class)->only(['index']);
        Route::apiResource('wallet-transactions',       WalletTransactions::class)->only(['index']);

        Route::get('logout',    Logout::class);
    });
});
