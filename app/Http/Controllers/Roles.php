<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

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
        $data = $request->only('name', 'type');
        $role = Role::create($data);

        $role->givePermissionTo($request->permissions);

        return to_route('roles.index')->with('success', 'New role added!');
    }

    public function update(RoleRequest $request, $role)
    {
        $role = Role::findByName($role);

        // Don't change super agent and agent role names
        if (!in_array($role, [Role::SUPERAGENT, Role::AGENT]))
            $role->update(['name' => $request->name]);

//            Don't change agent's permissions
        if ($role != Role::AGENT) {
            $role->syncPermissions($request->permissions);
        }

        return  to_route('roles.show', $role->name)->with('success', 'Role edited!');
    }
}
