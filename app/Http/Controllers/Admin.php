<?php

namespace App\Http\Controllers;

use App\Helpers\RoleHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;

class Admin extends Users
{
    public function index()
    {
        return view('pages.manage-users.admin');
    }
}
