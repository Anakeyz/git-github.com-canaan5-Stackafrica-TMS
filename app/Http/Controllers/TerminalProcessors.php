<?php

namespace App\Http\Controllers;

use App\Models\TerminalProcessor;
use Illuminate\Http\Request;

class TerminalProcessors extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TerminalProcessor::class);
    }

    public function index()
    {
        return view('pages.terminal-processors.index');
    }

    public function update(Request $request, TerminalProcessor $terminalProcessor)
    {
        $data = $request->validate([

        ]);

        $terminalProcessor->update($data);

        return back()->with('pending', 'Terminal processor update awaiting approval.');
    }
}
