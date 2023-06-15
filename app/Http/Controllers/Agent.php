<?php

namespace App\Http\Controllers;

use App\Helpers\RoleHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

class Agent extends Users
{
    public function index()
    {
        return view('pages.agents.index');
    }
}
