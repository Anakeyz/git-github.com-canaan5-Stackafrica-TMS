<?php

namespace App\Http\Controllers;

use App\Http\Requests\TerminalRequest;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Support\Str;

class Terminals extends Controller
{
    public function index()
    {
        return view('pages.terminals.index');
    }

    public function store()
    {
        $user = User::where('email', request()->email)->first();
        $data = \request()->all();

        Terminal::create([
            'user_id'       => $user->id,
            'device'        => $data['device'],
            'tid'           => $data['tid'],
            'mid'           => $data['mid'],
            'serial'        => $data['serial'],
            'tmk'           => Str::random(38),
            'tsk'           => Str::random(38),
            'tpk'           => Str::random(38),
            'category_code' => fake()->randomNumber(4),
            'date_time'     => fake()->dateTime()->format('d/m/y H:i'),
            'name_location' => Str::random(40),
        ]);

        return to_route('terminals.index')->with('pending', 'Terminal update awaiting approval.');
    }

    public function update(TerminalRequest $request, Terminal $terminal)
    {
        empty($request->validated()) ? $terminal->changeStatus() : $terminal->update($request->validated());

        return back()->with('pending', 'Terminal update awaiting approval.');
    }
}
