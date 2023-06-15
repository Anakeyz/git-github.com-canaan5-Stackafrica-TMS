<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class Permissions extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return view('pages.access-control.permissions.index', compact('permissions'));
    }
}
