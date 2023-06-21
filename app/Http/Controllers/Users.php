<?php

namespace App\Http\Controllers;

use App\Helpers\RoleHelper;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class Users extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function create()
    {
        if (\request()->routeIs('agents.onboard')) {
            $roles = RoleHelper::getAgentRoles();
            $title = 'Agent Onboarding';
            $super_agents = Role::findByName('Super Agent')->users;
        }
        elseif(\request()->routeIs('admins.register')) {
            $roles = RoleHelper::getAdminRoles();
            $title = 'Admin Registration';
            $super_agents = collect();
        }
        else {
            abort(403, 'Invalid Request');
        }

        return view('pages.manage-users.register', compact('roles', 'title', 'super_agents'));
    }

    public function show(User $user)
    {
        $user->load('kycDocs', 'terminals');

        $transactions = (object) [
            'today_amount' => $user->transactions()->filterByDateDesc('today')->sum('amount'),
            'today_count' => $user->transactions()->filterByDateDesc('today')->count(),
            'week_amount' => $user->transactions()->filterByDateDesc('week')->sum('amount'),
            'week_count' => $user->transactions()->filterByDateDesc('week')->count(),
            'month_amount' => $user->transactions()->filterByDateDesc('month')->sum('amount'),
            'month_count' => $user->transactions()->filterByDateDesc('month')->count(),
            'year_amount' => $user->transactions()->filterByDateDesc('year')->sum('amount'),
            'year_count' => $user->transactions()->filterByDateDesc('year')->count(),
        ];

        return view('pages.manage-users.show', compact('user', 'transactions'));
    }

    public function store(RegisterUserRequest $request)
    {
        $data = $request->role == 'Agent' ? $request->validated() : $request->except('super_agent_id');

        $user = User::create($data); // Observer creates password, level and wallet;

        $user->assignRole($request->role);

        return to_route('users.show', $user)->with('success', "$request->role onboarding successful!");
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->with('success', 'Update successful!');
    }
}
