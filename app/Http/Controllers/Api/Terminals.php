<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Terminal;
use App\Rules\CurrentPin;
use Illuminate\Http\Request;

class Terminals extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Terminal::class);
    }

    public function update(Request $request, Terminal $terminal)
    {
        $request->validate([
            'pin' => 'digits:4|confirmed|not_in:0000',
            'admin_pin' => 'digits:4|confirmed|not_in:0000',
            'current_pin' => ['required_with:pin', new CurrentPin($terminal)],
            'current_admin_pin' => ['required_with:admin_pin', new CurrentPin($terminal)]
        ]);

        $terminal->fill($request->only(['pin', 'admin_pin']));
        $terminal->withoutApproval()->save();

        return MyResponse::success('Update successful!');
    }
}
