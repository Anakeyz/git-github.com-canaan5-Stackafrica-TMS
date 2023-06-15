<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(){
        $activities = Activity::latest()->get();

       return view('pages.activity.index', compact('activities') );
    }
}
