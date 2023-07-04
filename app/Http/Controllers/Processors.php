<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use Illuminate\Http\Request;

class Processors extends Controller
{
    public function index()
    {
        $processors = Processor::all();

        return view('pages.processors.index', compact('processors'));
    }
}
