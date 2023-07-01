<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use App\Models\Terminal;
use App\Models\TerminalProcessor;

class TerminalProcessors extends Controller
{
    public function index()
    {
        return view('pages.terminal-processors.index');
    }

//    public function store(TerminalRequest $request)
//    {
//        $user = User::whereEmail($request->email)->first();
//
//        Terminal::create([
//            'user_id'   => $user->id,
//            'device'    => $request->device,
//            'tid'       => $request->tid,
//            'mid'       => $request->mid,
//            'serial'    => $request->serial,
//            'group_id'  => $request->group_id,
//        ]);
//
//        return back()->with('pending', "New $user->email Terminal - $request->tid awaiting approval! ");
//    }
//
//    public function update(TerminalRequest $request, Terminal $terminal)
//    {
//        $terminal->update($request->validated());
//
//        return back()->with('pending', 'Terminal update awaiting approval.');
//    }
}
