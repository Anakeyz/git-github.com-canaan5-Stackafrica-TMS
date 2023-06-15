<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')
            ->withCount(['users', 'permissions'])
            ->with(['users' => fn($query) => $query->inRandomOrder()->limit(6)])
            ->get();

        return view('pages.access-control.roles.index', compact('roles'));
    }

    public function show($role)
    {
        $role = Role::findByName($role);

        $permissions = Permission::all()->sortBy('name')->pluck('name')->toArray();

        return view('pages.access-control.roles.show', compact('role', 'permissions'));
    }

    public function create()
    {
        $permissions = Permission::all();
        $types = User::GROUPS;

        return view('pages.access-control.roles.create', compact('permissions', 'types'));
    }

    public function store(RoleRequest $request)
    {
        try {
            $data = $request->only('name', 'type');
            $role = Role::create($data);

            $role->givePermissionTo($request->permissions);

            return to_route('roles.index')->with('success', 'New role added!');
        }
        catch (\Exception $exception) {
            return $this->getExceptionMsg($exception);
        }
    }

    public function update(RoleRequest $request, $role)
    {
        try {
            $role = Role::findByName($role);

            $role->update(['name' => $request->name]);

//            Don't change agents permissions
            if ($role->type != User::GROUPS[1]) {
                $role->syncPermissions($request->permissions);
            }

            return  to_route('roles.show', $role->name)->with('success', 'Role edited!');
        }
        catch (\Exception $exception) {
            return $this->getExceptionMsg($exception);
        }
    }
}
