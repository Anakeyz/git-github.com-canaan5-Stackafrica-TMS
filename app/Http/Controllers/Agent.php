<?php

namespace App\Http\Controllers;


class Agent extends Users
{
    public function index()
    {
        return view('pages.agents.index');
    }
}
