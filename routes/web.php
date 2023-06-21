<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Approvals;
use App\Http\Controllers\AssignUserRole;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Fees;
use App\Http\Controllers\GeneralLedgers;
use App\Http\Controllers\KycDocs;
use App\Http\Controllers\KycLevels;
use App\Http\Controllers\Ledger;
use App\Http\Controllers\Menus;
use App\Http\Controllers\Permissions;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Providers;
use App\Http\Controllers\Roles;
use App\Http\Controllers\Services;
use App\Http\Controllers\Routing;
use App\Http\Controllers\TerminalGroupTerminals;
use App\Http\Controllers\TerminalMenus;
use App\Http\Controllers\Terminals;
use App\Http\Controllers\Transactions;
use App\Http\Controllers\UserKycDocs;
use App\Http\Controllers\Users;
use App\Http\Controllers\Wallets;
use App\Http\Controllers\TerminalGroups;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');*/


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

    Route::prefix('manage-users')->group(function () {
        Route::controller(Admin::class)->prefix('admins')->name('admins.')->group(function () {
            Route::get('/admin', 'index')->name('index');
            Route::get('/register', 'create')->name('register');
        });

        Route::controller(Agent::class)->prefix('agents')->name('agents.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/onboard', 'create')->name('onboard');
        });
    });

    Route::controller(Wallets::class)->prefix('wallets')->name('wallets.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/transactions', 'transactions')->name('transactions');
        Route::post('/{wallet}/update-status', 'updateStatus')->name('update-status');
    });

    Route::controller(GeneralLedgers::class)->prefix('general-ledger')->name('general-ledger.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::get('/others', 'index')->name('others');
        Route::post('/{gl}/update', 'update')->name('update');
    });

    Route::get('/activities', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activities');

    Route::resource('users',                        Users::class)->only(['show', 'update', 'store']);
    Route::resource('terminals',                    Terminals::class)->except(['destroy', 'edit', 'create']);
    Route::resource('users.kyc-docs',               UserKycDocs::class)->shallow()->only(['index', 'create', 'store']);
    Route::resource('kyc-docs',                     KycDocs::class)->shallow()->except(['edit', 'show']);
    Route::resource('transactions',                 Transactions::class)->only('index');
    Route::resource('kyc-levels',                   KycLevels::class)->only(['index', 'store', 'update']);
    Route::resource('ledger',                       Ledger::class)->only('index');
    Route::resource('approvals',                    Approvals::class)->only(['index', 'update', 'destroy']);
    Route::resource('roles',                        Roles::class)->except(['edit', 'destroy']);
    Route::resource('permissions',                  Permissions::class)->only(['index', 'store', 'update']);
    Route::resource('roles.users',                  AssignUserRole::class)->only(['store', 'destroy']);
    Route::resource('services',                     Services::class)->only(['index', 'update']);
    Route::resource('terminal-groups',              TerminalGroups::class)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::resource('terminal-groups.terminals',    TerminalGroupTerminals::class)->only(['index', 'store']);
    Route::resource('providers',                    Providers::class)->only(['index', 'store', 'destroy']);
    Route::resource('menus',                        Menus::class)->only('index');
    Route::resource('terminals.menus',              TerminalMenus::class)->only('store');

    Route::get('kyc-documents', [KycDocs::class, 'display'])->name('display');
    Route::get('/services/json', [Services::class, 'jsonData'])->name('services.json');

    Route::resource('routing',Routing::class);

    Route::withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->group(function () {
        Route::resource('terminal-groups.fees', Fees::class)->only(['index', 'edit', 'update'])->shallow();

        Route::controller(Routing::class)->prefix('routing')->name('routing.')->group(function () {
            Route::get('/{routing}/settings', 'settings')->name('settings');
            Route::get('/settings/{type}/store', 'addSetting')->name('settings.add');
            Route::get('/settings/{type}/edit', 'addSetting')->name('settings.edit');
            Route::post('/settings/store', 'addSetting')->name('settings.store');
            Route::patch('/settings/update', 'updateSetting')->name('settings.update');
        });
    });
});

require __DIR__.'/auth.php';
