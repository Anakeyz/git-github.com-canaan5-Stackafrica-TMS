<?php

use App\Http\Controllers\Api\AirtimePurchase;
use App\Http\Controllers\Api\Authenticate;
use App\Http\Controllers\Api\Banks;
use App\Http\Controllers\Api\Dashboard;
use App\Http\Controllers\Api\DataPurchase;
use App\Http\Controllers\Api\ElectricityPurchase;
use App\Http\Controllers\Api\Loans;
use App\Http\Controllers\Api\Logout;
use App\Http\Controllers\Api\Terminals;
use App\Http\Controllers\Api\Transactions;
use App\Http\Controllers\Api\Transfer;
use App\Http\Controllers\Api\WalletTransactions;
use App\Http\Controllers\CableTvPurchase;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('auth',         Authenticate::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('dashboard', Dashboard::class);

        Route::apiResource('terminals',                 Terminals::class)->only('update');

        Route::apiResource('transactions',              Transactions::class)->only(['index']);
        Route::apiResource('wallet-transactions',       WalletTransactions::class)->only(['index']);
        Route::apiResource('banks',                     Banks::class)->only(['index']);
        Route::apiResource('loans',                     Loans::class)->only(['index', 'store', 'destroy']);

        Route::apiResource('validate-transfer',         Transfer::class)->only('index');
        Route::apiResource('transfer',                  Transfer::class)->only('store');

        Route::apiResource('airtime-services',          AirtimePurchase::class)->only('index');
        Route::apiResource('airtime-purchase',          AirtimePurchase::class)->only('store');

        Route::apiResource('data-plans',                DataPurchase::class)->only('index');
        Route::apiResource('data-purchase',             DataPurchase::class)->only('store');

        Route::apiResource('cabletv-plans',             CableTvPurchase::class)->only('index');
        Route::apiResource('validate-cabletv',          CableTvPurchase::class)->only('show');
        Route::apiResource('cabletv-purchase',          CableTvPurchase::class)->only('store');

        Route::apiResource('electricity-distributors',  ElectricityPurchase::class)->only('index');
        Route::apiResource('validate-meter',            ElectricityPurchase::class)->only('show');
        Route::apiResource('electricity-purchase',      ElectricityPurchase::class)->only('store');

        Route::get('logout',    Logout::class);
    });
});
