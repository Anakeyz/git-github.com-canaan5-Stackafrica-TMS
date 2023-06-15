<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function pgNum()
    {
        return config('app.pagination');
    }

    protected function getExceptionMsg(\Exception $exception): RedirectResponse
    {
        $msg = env('APP_ENV') == 'production' ?
            'An Error Exception occurred!' : $exception->getMessage();

        return back()->with('error', $msg);
    }
}
