<?php

namespace App\Http\Controllers;

use App\Http\Requests\TerminalRequest;
use App\Models\Processor;
use App\Models\Terminal;
use App\Models\User;

class TerminalProcessor extends Controller
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


    public static function createForTerminal(Terminal $terminal)
    {
        $processors = Processor::all();

        foreach ($processors as $processor) {
            $terminalProcessor = new \App\Models\TerminalProcessor();

            $terminalProcessor->user_id = $terminal->user_id;
            $terminalProcessor->serial = $terminal->serial;
            $terminalProcessor->processor_id = $processor->id;
            $terminalProcessor->processor_name = $processor->name;
            $terminalProcessor->processor_name = $terminal->serial;
            $terminalProcessor->tid = "00000000";
            $terminalProcessor->mid = "000000000000000";
            $terminalProcessor->category_code = "0000";

            $terminalProcessor->withoutApproval()->save();
        }
    }
}
