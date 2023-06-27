<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read admin');

        $activities = Activity::latest()->get();

       return view('pages.activity.index', compact('activities') );
    }
}
