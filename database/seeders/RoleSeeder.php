<?php

namespace Database\Seeders;

use App\Helpers\AppConfig;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Seed permissions
        collect($this->permissionsSeeder())->each(fn($value) => Permission::create(['name' => $value]));

        $staff_roles = ['Super Admin', 'Admin'];
        $agent_roles = ['Super Agent', 'Agent'];

//        create roles for admin and super admin
        collect($staff_roles)->each(function ($value) {
            $role = Role::create([
                'name' => $value,
                'type' => User::GROUPS[0]
            ]);

//        Get all permissions except those belonging to agents and super agents;
            $permissions = Permission::whereNotIn('name', ['access super agent', 'access agent'])->pluck('name')->toArray();
            $role->givePermissionTo($permissions);
        });

        $role = Role::create([
            'name' => 'Approver',
            'type' => User::GROUPS[0]
        ]);

        $role->givePermissionTo('approve actions');

        collect($agent_roles)->each(fn($value) => Role::create([
            'name' => $value,
            'type' => User::GROUPS[1]
        ]));

        Role::findByName('Agent')->givePermissionTo('access agent');
        Role::findByName('Super Agent')->givePermissionTo('access super agent');
    }

    private function permissionsSeeder(): array
    {
        return [
            'access admin',
            'access super agent',
            'access agent',
            'read users',
            'create user',
            'modify user',
            'disable user',
            'read kyc-level',
            'modify kyc-level',
            'read roles',
            'create role',
            'edit roles',
            'delete roles',
            'edit permission',
            'read wallets',
            'modify wallet',
            'read terminals',
            'create terminal',
            'edit terminal',
            'delete terminal',
            'read fees',
            'modify fees',
            'read general ledger',
            'modify general ledger',
            'read ledger',
            'read dispute',
            'create dispute',
            'modify dispute',
            'read settings',
            'modify settings',
            'read accounts',
            'approve actions'
        ];

    }
}
