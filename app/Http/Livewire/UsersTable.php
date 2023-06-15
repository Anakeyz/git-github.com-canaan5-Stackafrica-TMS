<?php

namespace App\Http\Livewire;

use App\Helpers\RoleHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Route;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersTable extends Component
{
    use WithPagination;

    public string $name;
    public bool $showRole = true;
    public bool $showLevel = false;
    public bool $showAction = true;
    public ?string $roleAction = null;
    public ?Role $role = null;

    public function render()
    {
        if ($this->name == 'agents') {
            $users = User::role(RoleHelper::getAgentRoles())
                ->with('kycLevel')->latest()
                ->paginate(config('app.pagination'));
        }
        elseif ($this->name == 'admins') {
            $users = User::role(RoleHelper::getAdminRoles())
                ->with('kycLevel')->latest()
                ->paginate(config('app.pagination'));
        }
        else {
            $users = $this->role->users()->paginate(config('app.pagination'));
        }

        return view('pages.manage-users.table', compact('users'));
    }
}
